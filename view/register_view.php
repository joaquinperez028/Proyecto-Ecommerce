<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="assets/css/registro.css">
    <link rel="stylesheet" href="assets/css/errores.css">
    <link rel="stylesheet" href="assets/css/helpText.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Registrarse</title>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <main class="main-content">
        <form method="POST" action="index.php?controller=user&action=registrar">
            <?php if (!empty($mensajeError)) : ?>
                <div class="mensajeError">
                    <?php echo $mensajeError; ?>
                </div>
            <?php endif; ?>
            <h2>Registrarse</h2>
            <div class="form-group">
                <input type="text" name="name" placeholder="Nombre de Usuario" required onfocus="showHelpText(this, 'Ingrese un nombre de usuario que contenga entre 3 a 20 caracteres. No puede contener espacios.')" onblur="hideHelpText()">
                <div class="help-text" id="help-text"></div>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required onfocus="showHelpText(this, 'Ingrese un correo electrónico válido.')" onblur="hideHelpText()">
                <div class="help-text" id="help-text"></div>
            </div>
            <div class="form-group">
                <input id="password" type="password" name="password" placeholder="Password" required onfocus="showHelpText(this, 'La contraseña debe tener entre 8 y 20 caracteres, incluyendo una letra mayúscula, una letra minuscula, un caracter especial y un número.')" onblur="hideHelpText()">
                <div class="help-text" id="help-text"></div>
                <button id="btnmostrar" type="button" onclick="togglePassword()">Mostrar</button>
            </div>
            <div class="form-group">
                <input id="password2" type="password" name="password2" placeholder="Confirmar Password" required onfocus="showHelpText(this, 'Repita la contraseña para confirmar.')" onblur="hideHelpText()">
                <button id="btnmostrar2" type="button" onclick="togglePassword2()">Mostrar</button>
                <div class="help-text" id="help-text"></div>
                
            </div>
            <div class="form-group">
                <select name="opcionSeguridad" id="opcion" onfocus="showHelpText(this, 'Seleccione una pregunta de seguridad.')" onblur="hideHelpText()">
                    <option value="Nombre de tu primer mascota">Nombre de tu primer mascota</option>
                    <option value="Lugar donde cursaste primaria">Lugar donde cursaste primaria</option>
                    <option value="Dibujo animado favorito">Dibujo animado favorito</option>
                </select>
                <div class="help-text" id="help-text"></div>
            </div>
            <div class="form-group">
                <input type="text" name="respuestaSeguridad" placeholder="Respuesta" required onfocus="showHelpText(this, 'Ingrese la respuesta a la pregunta de seguridad seleccionada.')" onblur="hideHelpText()">
                <div class="help-text" id="help-text"></div>
            </div>
            <button id="btnRegister" type="submit">Register</button>
            <a href="index.php?controller=user&action=verLogin">Ya tengo cuenta</a>
        </form>
    </main>

    <?php include 'footer.php' ?>
    <script src="assets/js/ocultarContrasenia.js"></script>
    <script src="assets/js/helpText.js"></script>
</body>
</html>
