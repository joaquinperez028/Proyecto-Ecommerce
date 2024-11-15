<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/errores.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="login-container">
        <form action="index.php?controller=user&action=cambiarPassword" method="POST" class="login-form">
        <input type="hidden" name="ID_Usuario" value="<?php echo $obtenerID['ID']  ?>">
        <?php if (!empty($mensajeError)) : ?>
                <div class="mensajeError">
                    <?php echo $mensajeError; ?>
                </div>
            <?php endif; ?>
        <label for="passwordNuevo">Ingrese la nueva Contraseña: </label>
        <input id="password" type="password" name="password" required>
        <button class="btnmostrar" id="btnmostrar" type="button" onclick="togglePassword()">Mostrar</button>
        <label for="passwordNuevoConfirmacion">Ingrese nuevamente la Contraseña: </label>
        <input id="password2" type="password" name="password2" required>
        <button class="btnmostrar" id="btnmostrar2" type="button" onclick="togglePassword2()">Mostrar</button>
        <input type="submit" value="Cambiar Contraseña">
        </form>
    </div>
    <?php include 'footer.php' ?>
    <script src="assets/js/ocultarContrasenia.js"></script>
</body>
</html>