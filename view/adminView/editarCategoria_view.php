<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarProducto.css">
    <title>Editar Categoria</title>
</head>
<body>
    <?php include 'view/header.php' ?>

    <main>
        <section class= "modificarCategoria">
            <p><h4>Categoria a modificar:</h4><?php echo $categoria['Nombre']  ?></p>
            <form action="index.php?controller=productos&action=actualizarCategoria" method="POST">
                <input type="hidden" name="ID_Categoria" value="<?php echo $categoria['ID_Categoria'] ?>">
                <label for="nuevaCat">Ingrese el nuevo nombre de la categoria:</label>
                <input type="text" name="catModificada" required>
                <input type="submit" value="Modificar">
            </form>
        </section>
    </main>
</body>
</html>