<?php include 'view/privado/general/cabecera_privada.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarEstadoPedido.css">
    <title>Carrito</title>
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <section>
        <table border="1">
            <thead>
                <tr>
                    <th>Imagen del producto</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Color</th>
                    <th>Talle</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php $sumaTotal = 0; ?>
                <?php if(empty($productosEnCarrito)) { ?>
                 <td colspan= "8">¡No tiene productos en el carrito!</td>
                <?php } else {?>  
                    <?php foreach($productosEnCarrito as $productos) { ?>
                    <tr> 
                    <td><img src="<?php echo $productos['ruta_imagen'] ?>" alt="imagenProducto" width="128px"></td>
                    <td><?php echo $productos['Nombre'] ?></td>
                    <td><?php echo $productos['cantidad'] ?></td>
                    <td><?php echo $productos['color'] ?></td>
                    <td><?php echo $productos['talle'] ?></td>
                    <td>$<?php echo $productos['precioUnitario'] ?></td>
                    <td>$<?php echo $productos['precioTotal'] ?></td>
                    <td>
                        <form action="index.php?controller=carrito&action=eliminarDelCarrito" method="post">
                            <input type="hidden" name="ID_Producto" value="<?php echo $productos['ID_Producto'] ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                    </tr>  
                    <?php $sumaTotal += $productos['precioTotal']; ?> 
                    <?php } ?>
                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                <td colspan="8"><h1>Valor Total de la compra: $<?php echo $sumaTotal; ?></h1></td>
                </tr>
                
                <td colspan="2">
                    <form action="index.php?controller=carrito&action=vaciarCarrito" method="post">
                        <input type="hidden" name="ID_Producto" value="<?php echo $productos['ID_Producto'] ?>">
                        <input type="submit" value="Vaciar Carrito">
                    </form>
                </td>
                <td colspan="2">
                    <form action="index.php?controller=productos&action=verProductos" method="post">
                        <input type="submit" value="Continuar Comprando">
                    </form>
                </td>
                <td colspan="4">
                <form action="index.php?controller=pedido&action=generarPedido" method="post">
                        <input type="hidden" name="total" value="<?php echo $sumaTotal; ?>">
                        <input type="hidden" name="ID_Carrito" value="<?php echo $carritoID['ID_Carrito'] ?>">
                        <input type="submit" value="Finalizar Compra">
                    </form>
                </td>
            </tfoot>
        </table>
        </section>
    </main>
    <?php include 'view/footer.php' ?>
</body>
</html>
