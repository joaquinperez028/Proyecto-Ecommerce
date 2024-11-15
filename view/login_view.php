<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/errores.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Login</title>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <div class="login-container">
        <form action="index.php?controller=user&action=login" method="POST" class="login-form">
            <?php if (!empty($mensajeError)) : ?>
                <div class="mensajeError">
                    <?php echo $mensajeError; ?>
                </div>
            <?php endif; ?>
            <h2>Login</h2>
            <label for="correoElectronico">Correo electrónico</label>
            <input type="email" name="email" id="correoElectronico" placeholder="email" required>
            
            <div class="contrasenia">
            <label for="contraseña">Contraseña</label>
            <input id="password" type="password" name="password" id="contraseña" placeholder="contraseña" required>
            <button class="btnmostrar" id="btnmostrar" type="button" onclick="togglePassword()">Mostrar</button>
            </div>

            
            <input type="submit" value="Login">
            
            <div class="login-links">
                <a href="index.php?controller=user&action=verRegistro">No tengo cuenta</a>
                <a href="index.php?controller=user&action=verRecuperarPassword">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
    
    <?php include 'footer.php' ?>
    <script src="assets/js/ocultarContrasenia.js"></script>
</body>
</html>
