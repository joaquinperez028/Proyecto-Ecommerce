<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarProducto.css">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Productos</title>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este producto?");
        }
    </script>
</head>
<body>

    <?php include 'view/header.php'; ?>

    <main>
        <section>
            <table border="1">
            <tbody>
            <tr>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Tipo de Stock</th>
                <th>Estado</th>
                <th>Talles</th>
                <th>Colores</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Administrador</th>
                <th>Categoria</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            <tr>
                <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['ID_Producto']; ?></td>
                            <td><?php echo $producto['Nombre']; ?></td>
                            <td><?php echo $producto['tipoStock']; ?></td>
                            <td><?php if(!empty($producto['estado'])){ echo $producto['estado']; } 
                                else {
                                    echo 'Stock controlado';
                                }
                            ?></td>
                            <td><?php echo $producto['Talle']; ?></td>
                            <td><?php echo $producto['Color']; ?></td>
                            <td>$<?php echo $producto['Precio']; ?></td>
                            <td><?php echo $producto['Descripcion']; ?></td>
                            <td><?php echo $producto['nombreAdmin']; ?></td>
                            <td><?php echo $producto['nombreCat']; ?></td>
                            <td>
                                <form action="index.php?controller=productos&action=modificarProducto" method="post">
                                <input type="hidden" name="ID_Producto" value="<?php echo $producto['ID_Producto']; ?>">
                                <input type="submit" value="Modificar">
                                </form>
                            </td>
                            <td>                            
                                <form action="index.php?controller=productos&action=eliminarProducto" method="post" onsubmit="return confirmarEliminacion();">
                                <input type="hidden" name="ID_Producto" value="<?php echo $producto['ID_Producto']; ?>">
                                <input type="submit" value="Eliminar">
                                </form>
                            </td>
                            
                        </tr>
                <?php endforeach; ?>
            </tr>
            </tbody>

            </table>
        </section>
    </main>

</body>
</html>