<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarProducto.css">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Modificar Producto</title>
</head>
<body>


<?php include 'view/header.php' ?>

<main>
    <section>
        <h3>Producto a modificar</h3>
        <table>
            <thead>
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
                    <?php if($productoInfo['tipoStock'] === "produccion"):?>
                        <th>Agregar/Quitar de produccion</th>
                    <?php endif; ?>
                    <th>Modificar Imagen</th>
                    <th>Modificar Categoria</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $productoInfo['ID_Producto']; ?></td>
                    <td><?php echo $productoInfo['Nombre']; ?></td>
                    <td><?php echo $productoInfo['tipoStock']; ?></td>
                    <td><?php echo $productoInfo['estado']; ?></td>
                    <td><?php echo $productoInfo['Talles']; ?></td>
                    <td><?php echo $productoInfo['Color']; ?></td>
                    <td><?php echo $productoInfo['Precio']; ?></td>
                    <td><?php echo $productoInfo['Descripcion']; ?></td>
                    <td><?php echo $productoInfo['nombreAdmin']; ?></td>
                    <td><?php echo $productoInfo['nombreCat']; ?></td>
                    <?php if($productoInfo['tipoStock'] === "produccion"): ?>
                    <td>
                        <?php   if ($productoInfo['estado'] === "En produccion"):?>
                            <form action="index.php?controller=productos&action=quitarProductoDeProduccion" method="post">
                                <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto']; ?>">
                                <input type="submit" value="Quitar de produccion">
                            </form>
                        <?php endif; ?>
                        <?php  if ($productoInfo['estado'] === "Fuera de produccion"): ?>
                            <form action="index.php?controller=productos&action=AgregarProductoAProduccion" method="post">
                            <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto']; ?>">
                            <input type="submit" value="Reanudar produccion">                                
                            </form>

                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <td>
                    <form action="index.php?controller=productos&action=modificarImagen" method="POST">
                        <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto']; ?>">
                        <input type="submit" value="Modificar">
                    </form>
                    </td>
                    <td>
                    <form action="index.php?controller=productos&action=modificarCategoria" method="POST">
                        <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto']; ?>">
                        <input type="submit" value="Modificar">
                    </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <form action="index.php?controller=productos&action=actualizarProducto" method="post">
            <input type="hidden" name="ID_Producto" value="<?php echo $productoInfo['ID_Producto']; ?>">
            <select name="opcionModificada" id="opcionAModificar">
                <option value="Nombre">Nombre Producto</option>
                <option value="Precio">Precio</option>
                <option value="Descripcion">Descripcion del producto</option>
            </select>
            <input type="text" name="modificacion" placeholder="Ingrese Modificación" required>
            <input type="submit" value="Modificar">
        </form>
    </section>
</main>


</body>
</html>