<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarImagenProducto.css">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Modificar Imagen</title>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar esta imagen?");
        }
    </script>
</head>
<body>
    
    <?php include 'view/header.php'; ?>

    <main>
        <section>
            <table>
                <thead>
                    <th>Imagen ID</th>
                    <th>Imagen</th>
                    <th>Ruta</th>
                    <th>Eliminar</th>
                </thead>
                <tbody>
                    <?php foreach ($imagenesProducto as $imagen ) {  ?>
                        <tr>
                            <td><?php echo $imagen['id_imagen'] ?></td>
                            <td><img src="<?php echo $imagen['ruta_imagen'] ?>" alt="imagenProducto" height="128px" width="128px">  </td> 
                            <td><?php echo $imagen['ruta_imagen'] ?></td>
                            <td>
                                <form action="index.php?controller=productos&action=eliminarImagenProducto" method="post" onsubmit="return confirmarEliminacion();">
                                    <input type="hidden" name="ID_Imagen" value="<?php echo $imagen['id_imagen'] ?>">
                                    <input type="hidden" name="ID_Producto" value="<?php echo $imagen['producto_id'] ?>">
                                    <input type="submit" value="Eliminar">
                                </form>
                            </td>                           
                        </tr> 
                    <?php } ?>   
                </tbody>
            </table>
            <form action="index.php?controller=productos&action=agregarImagenNueva" method="POST" enctype="multipart/form-data">
            
                <input type="hidden" name="ID_Producto" value="<?php echo $idProd['ID_Producto'] ?>">
                <input type="file" name="imagenNueva">
                <input type="submit" value="Agregar Imagen">
            </form>
        </section>
    </main>
    

</body>
</html>