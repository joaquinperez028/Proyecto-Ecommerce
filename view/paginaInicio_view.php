<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/paginaInicio.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title>Inicio</title>
</head>
<body>
    <?php include 'header.php' ?>
    <main>
    <?php 
        if(session_status() === PHP_SESSION_NONE) session_start();
         if (isset($_SESSION['user_id'])) { ?>
        <h1 class="Bienvenido">Bienvenido/a: <?php echo $_SESSION['nombre'] ?></h1>
        <?php } ?>
        <section>

        <div class="bannerPrincipal">
        
        </div>
        </section>
        <section>
        <div class="carrusel">
            <?php foreach ($ranking as $producto) : ?>
            <div class="producto">
                <img id="imagenes" src="<?php echo $producto['ruta_imagen']; ?>" alt="<?php echo $producto['Nombre']; ?>" width="100%">
                <p><?php echo $producto['Nombre']; ?></p>
                <p>Vendidos: <?php echo $producto['veces_vendido']; ?></p>
                <form action="index.php?controller=productos&action=verProductoUnico" method="post" class="formVer">
                    <input type="hidden" name="ID_Producto" value="<?php echo $producto['ID_Producto'] ?>">
                    <input type="submit" value="Ver">
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="boton">
        <a id="verProductos" href="index.php?controller=productos&action=verProductos">Ver Productos</a>
        </div>

        </section>
        <section>
            <div class="infoEmpresa">
            <h2>Micolvio: Donde la Moda Deportiva y Casual se Encuentran</h2>

            <p>En Micolvio, creemos que la ropa deportiva no solo debe ser funcional, sino también estilosa y versátil. Nuestra misión es ofrecer prendas que se adapten tanto a tus entrenamientos más intensos como a tus momentos de relajación y ocio.</p>

            <p>Desde nuestros inicios, nos hemos comprometido a combinar la más alta calidad con diseños innovadores. Cada pieza de nuestra colección está cuidadosamente elaborada con materiales de primera, asegurando comodidad y durabilidad. Ya sea que estés corriendo una maratón, practicando yoga, o simplemente disfrutando de un día casual, Micolvio tiene la prenda perfecta para ti.</p>

            <p>Nuestro equipo de diseñadores se inspira en las últimas tendencias de la moda y en las necesidades de nuestros clientes. Esto nos permite crear ropa que no solo se ve bien, sino que también se siente increíble. Además, en Micolvio nos enorgullece ser una empresa sostenible, utilizando procesos y materiales que respetan el medio ambiente.</p>

            <p>Únete a la familia Micolvio y descubre cómo nuestra ropa puede transformar tu estilo de vida. Porque en Micolvio, no solo vendemos ropa, sino que promovemos un estilo de vida activo y saludable, sin sacrificar el estilo.</p>
            </div>
        </section>
    </main>
    <?php include 'footer.php' ?>
    <style>
        footer{
            position: relative;
        }
    </style>
</body>
</html>