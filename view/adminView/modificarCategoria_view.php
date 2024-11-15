<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarProducto.css">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Modificar Categoria</title>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <main>
        <section class="modificarCategoria">
            <div class="titulo">
            <h4>Categoria actual:</h4> 
            <p><?php echo $productoInfo['nombreCat']?></p>
            </div>

            <form action="index.php?controller=productos&action=catModificada" method="POST">
            <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto'] ?>">
            <label for="catNueva">Seleccione la nueva categoria</label>
            <select name="categoriaEditada">
                <?php foreach($categorias as $categoria) {?>
                <option value="<?php echo $categoria['Nombre']?>"><?php echo $categoria['Nombre']?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Modificar">


        </section>
    </main>

</body>
</html>