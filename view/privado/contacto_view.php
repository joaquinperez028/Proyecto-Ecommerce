<?php include 'view/privado/general/cabecera_privada.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/contacto.css">
    <title>Contacto</title>
</head>
<body>
    <?php include 'view/header.php'?>
    <section class="principal">
    <form action="" method="post" class="formContacto">
    <h1>Contacto</h1>
        <div class="mensaje">
        <label for="">Asunto: </label>
        <input type="text" name="" id="" maxlength="50">
        </div>
        <div class="mensaje">
        <label for="">Mensaje: </label>
        <textarea name="" id="" cols="30" rows="10"></textarea>
        </div>
        <input type="submit" value="Enviar">
    </form>
    </section>


    <?php include 'view/footer.php'?>
</body>
</html>