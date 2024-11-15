<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/styleProductos.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Productos</title>
</head>
<body>

    <?php include 'header.php' ?>

    <main>
        <section>
            <div class="contenedorProductos">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">

                    <div class="imagenProducto">
                    <img src="<?php echo $producto['ruta_imagen']; ?>" alt="Imagen de <?php echo $producto['Nombre']; ?>" width="150" height="150">
                    </div>

                    <div class="infoProducto">
                    <?php echo $producto['Nombre']; ?>
                    <br>
                    <?php echo '$'. $producto['Precio']; ?>
                    </div>

                    <form action="index.php?controller=productos&action=verProductoUnico" method="post">
                    <input type="hidden" name="ID_Producto" value="<?php echo $producto['ID_Producto']; ?>">
                    <input type="submit" value="Ver">
                    </form>

                </div>                
            <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>