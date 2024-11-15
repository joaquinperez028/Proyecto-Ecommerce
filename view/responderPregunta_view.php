<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/errores.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Responder Pregunta</title>
</head>
<body>

    <?php include 'header.php'; ?>
    <div class="login-container">
        <form action="index.php?controller=user&action=responderPregunta" method="post" class="login-form">
            <input type="hidden" name="ID_Usuario" value="<?php echo $recuperarContraseña['user']['ID']?>">
            <?php if (!empty($mensajeError)) : ?>
                <div class="mensajeError">
                    <?php echo $mensajeError; ?>
                </div>
            <?php endif; ?>
            <label for="pregunta">
            <?php
            if(!empty($recuperarContraseña)){
            echo $recuperarContraseña['user']['preguntaSeguridad'];                
            }
            else{
                echo 'Pregunta';
            }
            ?>
            :
            </label>
            <input type="text" name="respuestaSeguridad" placeholder="Respuesta" required>
            <input type="submit" value="Enviar">
        </form>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>