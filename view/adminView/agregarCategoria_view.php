 <?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/agregarCategoria.css">
    <title>Agregar Categoría</title>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar esta categoría?");
        }
    </script>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <main>
        <section class="contenedor">
            <h2>Categorías Existentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?php echo $categoria['ID_Categoria']; ?></td>
                            <td><?php echo $categoria['Nombre']; ?></td>
                            <td>
                                <form action="index.php?controller=productos&action=editarCategoria" method="post">
                                    <input type="hidden" name="ID_Categoria" value="<?php echo $categoria['ID_Categoria']; ?>">
                                    <input class="btnEditar" type="submit" value="Modificar">
                                </form>
                            </td>
                            <td>
                                <form action="index.php?controller=productos&action=eliminarCategoria" method="post" onsubmit="return confirmarEliminacion();">
                                    <input type="hidden" name="ID_Categoria" value="<?php echo $categoria['ID_Categoria']; ?>">
                                    <input class="btnEditar" type="submit" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a class="btn-agregar" href="index.php?controller=productos&action=agregarProducto">Agregar producto</a>

            <form action="index.php?controller=productos&action=crearCategoria" method="post" class="form-crear-categoria">
                <h3>Crear categoría de productos</h3>
                <label for="CrearCategoria">Nombre de la categoría</label>
                <input type="text" name="nombreCategoria" required>
                <input type="submit" value="Crear" class="btn-submit">
            </form>
        </section>
    </main>

</body>
</html>
