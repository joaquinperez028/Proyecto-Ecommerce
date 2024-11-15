<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/agregarProductos.css">
    <title>Agregar Productos</title>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <main>
        <section class="contenedor">
        <form action="index.php?controller=productos&action=agregarProducto" method="post" enctype="multipart/form-data" class="form-producto" onsubmit="return validarFormulario()">

        <h2>Agregar Producto</h2>

        <div class="campo">
            <label for="nombreProducto">Nombre del producto:</label>
            <input type="text" name="nombreProducto" id="nombreProducto" required>
        </div>

        <div class="campo">
            <label for="categoriaProducto">Seleccione la categoría del producto:</label>
            <select name="categoriaProducto" id="categoriaProducto" required>
                <option value="">Seleccione una categoria</option>
                <?php foreach($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria['Nombre']; ?>"><?php echo $categoria['Nombre']; ?></option>
                <?php } ?>
            </select>
            <a href="index.php?controller=productos&action=crearCategoria" class="link-crear-categoria">Crear nueva categoría</a>
        </div>

        <div class="campo">
            <label for="archivos">Seleccione las fotos del producto:</label>
            <input type="file" name="imagenesProducto[]" id="archivos" multiple required>
        </div>

        <div class="campo">
            <label>Seleccione los colores disponibles:</label><br>
            <div class="opciones" required>
                <label for="colorRojo"><input type="checkbox" name="colores[]" id="colorRojo" value="rojo"> Rojo</label>
                <label for="colorVerde"><input type="checkbox" name="colores[]" id="colorVerde" value="verde"> Verde</label>
                <label for="colorAzul"><input type="checkbox" name="colores[]" id="colorAzul" value="azul"> Azul</label>
                <label for="colorAmarillo"><input type="checkbox" name="colores[]" id="colorAmarillo" value="amarillo"> Amarillo</label>
                <label for="colorNegro"><input type="checkbox" name="colores[]" id="colorNegro" value="negro"> Negro</label>
                <label for="colorBlanco"><input type="checkbox" name="colores[]" id="colorBlanco" value="blanco"> Blanco</label>
                <label for="colorGris"><input type="checkbox" name="colores[]" id="colorGris" value="gris"> Gris</label>
                <label for="colorRosa"><input type="checkbox" name="colores[]" id="colorRosa" value="rosa"> Rosa</label>
            </div>
        </div>

        <div class="campo">
            <label for="tipoStock">Tipo de Stock:</label>
            <select name="tipoStock" id="tipoStock" required>
                <option value="produccion">Stock por producción</option>
                <option value="fisico">Stock físico</option>
            </select>
        </div>

        <div class="campo">
            <label>Seleccione los talles disponibles:</label><br>
            <div class="opciones">
                <label for="talleXS"><input type="checkbox" name="talles[]" id="talleXS" value="XS"> XS</label>
                <label for="talleS"><input type="checkbox" name="talles[]" id="talleS" value="S"> S</label>
                <label for="talleM"><input type="checkbox" name="talles[]" id="talleM" value="M"> M</label>
                <label for="talleL"><input type="checkbox" name="talles[]" id="talleL" value="L"> L</label>
                <label for="talleXL"><input type="checkbox" name="talles[]" id="talleXL" value="XL"> XL</label>
            </div>
        </div>

        <div id="contenedorStockFisico" style="display:none;">
            <h3>Stock por talles:</h3>
            <div class="campo" id="stockTalles"></div>
        </div>

        <div class="campo">
            <label for="precioProducto">Precio del producto:</label>
            <input type="number" name="precioProducto" id="precioProducto" step="any" required>
        </div>

        <div class="campo">
            <label for="descripcionProducto">Descripción del producto:</label>
            <textarea name="descripcionProducto" id="descripcionProducto" cols="30" rows="5" required></textarea>
        </div>

        <input type="hidden" name="idAdmin" value="<?php echo $_SESSION['idAdmin'] ?>">

        <div class="campo">
            <input type="submit" value="Agregar" class="btn-submit">
        </div>

        </form>
        </section>
    </main>
    <script src="assets/js/agregarproducto.js"></script>

</body>
</html>
