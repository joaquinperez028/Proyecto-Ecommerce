<?php
// Incluir el archivo de configuración de la base de datos y la clase User


require 'model/user_model.php';
function verRegistro ()
{   
   include 'view/register_view.php';
}

function verLogin ()
{   
   include 'view/login_view.php';
}

function verRecuperarPassword ()
{
    include 'view/forgotPassword_view.php';
}

function verContacto(){
    include 'view/privado/contacto_view.php';
}

function registrar(){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Crear una instancia de la clase User, pasando la conexión PDO como argumento
        $user = new User();
        // Sanitizar la entrada del usuario y lo registra

        $resultado = $user->register(htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['password2']), htmlspecialchars($_POST['opcionSeguridad']), htmlspecialchars($_POST['respuestaSeguridad']));
       // Redirigir al usuario a la página de inicio de sesión después del registro
       if ($resultado['status'] === false) {

        $mensajeError = $resultado['error'];
        include 'view/register_view.php';

        } else {
            $mensajeError = $resultado['error'];
            include 'view/login_view.php';
            echo '<script> alert("Registro completado con exito;."); </script>';
        }
    }

}

function login() {
    
    // Verificar si se recibió una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Crear una instancia de la clase User
        $user = new User();
        
        // Sanitizar la entrada del usuario e intenta iniciar sesión
        $resultado = $user->login(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));

        if ($resultado['status'] === true) {
            // Si el login es exitoso, iniciar la sesión
            session_start();
            $_SESSION['user_id'] = $resultado['user']['ID'];
            
            // Redirigir al usuario a la página de bienvenida
            header('Location: index.php?controller=user&action=consultarDatos');
            exit();
        } else {
            // Mostrar un mensaje de error si las credenciales de inicio de sesión son incorrectas
            $mensajeError = $resultado['error'];
            include 'view/login_view.php';
        }
    }
}



function recuperar() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new User();

        $recuperarContraseña = $user->recuperarContraseña(htmlspecialchars($_POST['email']));
        
        

        if($recuperarContraseña['status'] === true){
            include 'view/responderPregunta_view.php';
        }
        else {
            // Mostrar el mensaje de error
            $mensajeError = $recuperarContraseña['error'];
            include 'view/forgotPassword_view.php';
            echo '<meta http-equiv="refresh" content="3;url=index.php?controller=user&action=verLogin">';
            exit();
        }
        
    }

}

function responderPregunta() {


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new User();

        $obtenerID = $user ->obtenerIdUsuario(htmlspecialchars($_POST['ID_Usuario']));
        $compararContraseñas = $user -> buscarRespuesta(htmlspecialchars($_POST['respuestaSeguridad']), htmlspecialchars($_POST['ID_Usuario']));

        if($compararContraseñas['status'] === true){
            
            include 'view/cambiarPassword_view.php';

        }
        else {
            $mensajeError = $compararContraseñas['error'];
            include 'view/responderPregunta_view.php';
            echo '<meta http-equiv="refresh" content="3;url=index.php?controller=user&action=verLogin">';
            exit();

        }
    }    
}

function cambiarPassword () {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new User();

        $obtenerID = $user ->obtenerIdUsuario(htmlspecialchars($_POST['ID_Usuario']));
        $resultado = $user->cambiarPassword(htmlspecialchars($_POST['password']), htmlspecialchars($_POST['password2']), htmlspecialchars($_POST['ID_Usuario']));

        // Si la contraseña fue cambiada con éxito
        if($resultado['status'] === true) {
            echo '<Script> alert("Contraseña cambiada con exito") </Script>';
            include 'view/login_view.php';
            exit();
        } else {
            $mensajeError = $resultado['error'];
            include 'view/cambiarPassword_view.php';
        }
    }
}

function consultarDatos (){
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $user = new User();

        $infoUser = $user -> consultarDatos();

        if ($infoUser){
            header('Location: index.php?controller=carrito&action=crearCarrito');
        } else {
            echo 'no se pudo obtener los datos de la cuenta';
        }
    }
}

function verUsuarios() {
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $UsuarioModificado = $user->agregarAdministrador(htmlspecialchars($_POST['ID_Usuario']));
        if ($UsuarioModificado) {
            header('Location: index.php?controller=user&action=verUsuarios');
            exit();
        } else {
            echo '<script>alert("Hubo un error al intentar promover al usuario.")</script>';
        }
    }

    $Admins = $user->obtenerAdmins();
    $Usuarios = $user->obtenerUsuarios();
    include 'view/adminView/modificarUsuarios_view.php';
}


function quitarAdmin (){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();

            $adminModificado = $user->quitarAdmin(htmlspecialchars($_POST['ID_Administrador']),htmlspecialchars($_POST['ID_Usuario']));
        
            if ($adminModificado) {
                header('Location: index.php?controller=user&action=verUsuarios');
            } else {
                echo 'Hubo un error al intentar degradar al administrador.';
            }
        }
}

function logout() {
    session_start();
    session_destroy();
    echo '<script> alert("Session Cerrada con exito") </script> ';
    include 'view/login_view.php';
}

?>