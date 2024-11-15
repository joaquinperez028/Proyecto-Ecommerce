<?php
// Definición de la clase User
require "config.php";

class User {
     // Propiedad privada para almacenar la conexión PDO a la base de datos
    
    private $pdo;
    //PDO (PHP Data Objects) es una extensión de PHP que proporciona una interfaz uniforme para acceder a bases de datos desde PHP
    // Constructor que recibe la conexión PDO como argumento
    public $mensajeError= '';
    

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function register($name, $email, $password, $password2, $opcionSeguridad, $respuestaSeguridad) {
        
        $mensajeError = '';

        if (empty($name) || empty($email) || empty($password) || empty($password2) || empty($opcionSeguridad) || empty($respuestaSeguridad)) {
            $mensajeError = 'Ingresaste un campo vacío.';
        }
    
        elseif (strlen($name) > 15 || strlen($name) < 3) {
            $mensajeError = 'El nombre de usuario debe tener entre 3 y 15 caracteres.';
        }
    
        elseif (!self::corroborarUsuario($name)) {
            $mensajeError = 'Ingresaste caracteres especiales en el campo de usuario.';
        }
        
        elseif (self::buscarEmail($email)) {
            $mensajeError = 'El email ya está registrado.';
        }

        elseif (strlen($email) > 50) {
            $mensajeError = 'El email ingresado es demasiado largo.';
        }
    
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensajeError = 'El email ingresado no cumple con los estándares.';
        }
    
        elseif (strlen($password) > 20 || strlen($password) < 8) {
            $mensajeError = 'La contraseña debe tener entre 8 y 20 caracteres.';
        }
    
        elseif (!self::corroborarPassword($password)) {
            $mensajeError ='La contraseña debe contener una letra minúscula, una mayúscula, un número y un carácter especial (ej: !, ?, #, @).';
        }
    
        elseif ($password !== $password2) {
            $mensajeError = 'Las contraseñas ingresadas no coinciden.';
        }
    
        elseif (strlen($respuestaSeguridad) >=30) {
            $mensajeError = 'La respuesta de seguridad es demasiado larga.';
        }

        if ($mensajeError !== '') {
            return ['error' => $mensajeError, 'status' => false];
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $rol = "Cliente";
        
        $stmt = $this->pdo->prepare('INSERT INTO clientes (nombre, email, password, rol, preguntaSeguridad, respuestaSeguridad) VALUES (:nombre, :email, :password, :rol, :preguntaSeguridad, :respuestaSeguridad)');
        
        $stmt->execute(['nombre' => $name, 'email' => $email, 'password' => $hashedPassword, 'rol' => $rol, 'preguntaSeguridad' => $opcionSeguridad, 'respuestaSeguridad' => $respuestaSeguridad]);
        
        return ['error' => '', 'status' => true];

    } // function register

    
    private function corroborarUsuario($name) {

        $validacion = "/^[a-zA-Z\dñÑüÜáéíóúÁÉÍÓÚ]+$/"; // \d busca si tiene numeros del 0-9

        return preg_match($validacion, $name);
    }



    private function corroborarPassword($password) {

        $validacion = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/"; //si la cadena de texto que compara contiene almenos 1 minuscula, 1 mayuscula, 1 numero y un caracter especial 

        return preg_match($validacion, $password);
    }

    public function recuperarContraseña($email) {
        if(self::buscarEmail($email)) {
            $stmt = $this->pdo->prepare('SELECT ID, preguntaSeguridad FROM clientes WHERE email = :email');
            $stmt->execute(['email' => $email]);
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Retornar éxito
            return ['status' => true, 'user' => $user, 'error' => ''];
        } else {
            // Retornar error
            return ['status' => false, 'error' => 'El email no está registrado.'];
        }
    }

    public function obtenerIdUsuario($idUsuario){
        $stmt = $this->pdo->prepare('SELECT ID FROM clientes WHERE ID = :ID');
        $stmt->execute(['ID' => $idUsuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function cambiarPassword($password, $password2, $idUsuario) {

        $mensajeError= '';

        if($password != $password2) {
            $mensajeError = 'Las contraseñas ingresadas no coinciden entre ellas. Ingréselas nuevamente.';
        }
    
        elseif (strlen($password) > 20 || strlen($password) < 8) {
    
            if (strlen($password) > 20) {
                $mensajeError = 'La contraseña es demasiado larga. Debe tener máximo 20 caracteres.';
            } elseif (strlen($password) < 8) {
                $mensajeError = 'La contraseña es demasiado corta. Debe tener al menos 8 caracteres.';
            }
    
        }
    
        elseif (!self::corroborarPassword($password)) {
            $mensajeError = 'La contraseña debe contener al menos una letra minúscula, una mayúscula, un número y un carácter especial (ej: !, ?, #, @).';
        }
    
        if ($mensajeError !== '') {
            return ['status' => false, 'error' => $mensajeError];
        } 
    
        // Si no hay errores, procedemos con el cambio de contraseña
        $nuevoPasswordHashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('UPDATE clientes SET password = :nuevoPassword WHERE ID = :ID');
        $stmt->execute(['nuevoPassword' => $nuevoPasswordHashed, 'ID' => $idUsuario]);
    
        return ['status' => true];
    }

    public function buscarRespuesta($respuestaSeguridad, $idUsuario) {
        $stmt = $this->pdo->prepare('SELECT respuestaSeguridad, ID FROM clientes WHERE ID = :ID');
        $stmt->execute(['ID' => $idUsuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($respuestaSeguridad === $user['respuestaSeguridad']) {
            return ['status' => true, 'user' => $user, 'error' => ''];
        } else {
            return ['status' => false, 'error' => 'La respuesta de seguridad no coincide.'];
        }
    }

    private function buscarEmail($email){
    
          $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE email = :email');  
          $stmt->execute(['email' => $email]);
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
          
          
          if ($user) {
              return true;
          }
          return false;

    }

    public function login($email, $password) {
        // Preparar la consulta SQL para seleccionar al clientes por su email       
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE email = :email');
        // Ejecutar la consulta SQL, pasando el email como parámetro        
        $stmt->execute(['email' => $email]);
        // Obtener la fila del clientes de la base de datos
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($user)){

        $stmt = $this->pdo->prepare('SELECT * FROM administrador WHERE email = :email');       
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        }
    
        // Verificar si se encontró un email y si la password coincide con el hash almacenado
        if ($user && password_verify($password, $user['password'])) {
            return ['status' => true, 'user' => $user, 'error' => ''];
        }
    
        // Si no se encontró el clientes o la password no coincide, devolver un array con error
        return ['status' => false, 'user' => null, 'error' => 'Credenciales de inicio de sesión inválidas.'];
    }
    

    public function consultarDatos() {

        $user = $this->pdo->prepare('SELECT * FROM clientes WHERE id = :id && rol = "cliente"');
        $user->execute(['id' => $_SESSION['user_id']]);
        $user = $user->fetch(PDO::FETCH_ASSOC);

        if(empty($user)){

            $admin = $this->pdo->prepare('SELECT * FROM administrador WHERE id_usuario = :id_usuario');       
            $admin->execute(['id_usuario' => $_SESSION['user_id']]);
            $admin = $admin->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['nombre'] = $admin['nombre'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['rol'] = $admin['rol'];
            $_SESSION['idAdmin'] = $admin['ID'];

            if($_SESSION['nombre'] && $_SESSION['email'] && $_SESSION['rol'] ){

                return true;
    
            } else{
                echo $_SESSION['user_id'];
                return false;
                
            }
        } else{

            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rol'] = $user['rol'];

            if($_SESSION['nombre'] && $_SESSION['email'] && $_SESSION['rol'] ){

                return true;

            } else{
                echo $_SESSION['user_id'];
                return false;
                
            }
        }
        

    }

    public function obtenerUsuarios() {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes');
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $user;
    }

    public function obtenerAdmins(){
        $stmt = $this->pdo->prepare('SELECT * FROM administrador');
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $user;
    }

    public function agregarAdministrador($idUsuario) {
        $this->pdo->beginTransaction();
    
        try {

        $stmtCheck = $this->pdo->prepare('SELECT email FROM administrador WHERE id_usuario = :id');
        $stmtCheck->execute(['id' => $idUsuario]);
        $existingAdmin = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            
        if ($existingAdmin) {
                throw new Exception('El clientes ya es administrador.');
        }

        $stmtInsert = $this->pdo->prepare('INSERT INTO administrador (nombre, password, rol, preguntaSeguridad, respuestaSeguridad, email, id_usuario) SELECT nombre, password, :rol, preguntaSeguridad, respuestaSeguridad, email, ID FROM clientes WHERE ID = :id');
        $stmtInsert->execute(['id' => $idUsuario, 'rol' => 'Admin']);
    
        $stmtUpdate = $this->pdo->prepare('UPDATE clientes SET rol = :rol WHERE ID = :id');
        $stmtUpdate->execute(['id' => $idUsuario, 'rol' => 'Admin']);
    
            // Confirmar la transacción
            $this->pdo->commit();
            return true;
    
        } catch (Exception $e) {
            // Mostrar el error para depuración
            $e->getMessage();
            $this->pdo->rollback();
            return false;
        }
    }

    public function quitarAdmin($idAdmin, $idUsuario){
        $this->pdo->beginTransaction();

        try {

            $stmtDelete = $this->pdo->prepare('DELETE FROM administrador WHERE ID = :id');
            $stmtDelete->execute(['id' => $idAdmin]);

            $stmtUpdate = $this->pdo->prepare('UPDATE clientes SET rol = :rol WHERE ID = :id');
            $stmtUpdate->execute(['id' => $idUsuario, 'rol' => 'Cliente']);
        
                // Confirmar la transacción
                $this->pdo->commit();
                return true;
        
            } catch (Exception $e) {

                $e->getMessage();
                $this->pdo->rollback();
                return false;
            }
    }
    
}
?>
