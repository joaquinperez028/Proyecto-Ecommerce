<?php include 'view/privado/general/cabecera_privada.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarEstadoPedido.css">
    <title>Pedidos</title>
    <script>
        function confirmarPago() {
            return confirm("¿Ya realizo la transferencia y adjunto el comprobante al correo electronico?");
        }
    </script>
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <section>
            <span class="numeroCuenta">Para pagar por transferencia: <br>transferir a cuenta BROU (12345678-00001) Titular: Micol Vio<br> Adjuntar comprobante al correo electronico: micolvio@gmail.com</span>
            <table border="1">
                    <thead>
                    <th>Numero de Pedido</th>
                    <th>Estado</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Completar</th>
                    <th>Factura</th>
                    <th>Eliminar Pedido</th>
                </thead>
                <tbody>
                    <?php if(empty($pedidos)) {?> 
                        <td colspan="7">¡Usted no tiene ningun pedido!</td>
                    <?php } else {?>
                        <?php foreach($pedidos as $pedido) { ?>
                            <tr>
                            <td><?php echo $pedido['ID_Pedido'] ?></td>
                            <td><?php echo $pedido['estado'] ?></td>
                            <td><?php echo $pedido['Productos'] ?></td>
                            <td>$<?php echo $pedido['Total'] + $pedido['Total'] * 0.22  ?></td>
                            <td><?php if($pedido['estado'] === "En Proceso") { ?>
                                <form action="index.php?controller=pedido&action=rellenarPedido" method="post">
                                    <input type="hidden" name="ID_Pedido" value="<?php echo $pedido['ID_Pedido'] ?>">
                                    <input type="submit" value="Completar">
                                </form>
                                <?php } ?>
                                <?php if ($pedido['estado'] === "En espera de pago") { ?>
                                <form action="index.php?controller=pedido&action=actualizarPago" method="post" onsubmit="return confirmarPago();">
                                <input type="hidden" name="ID_Pedido" value="<?php echo $pedido['ID_Pedido'] ?>">
                                <input type="submit" value="Completar">
                                </form>
                                <?php } ?>
                                <?php if ($pedido['estado'] === "Procesando Pago") { ?>
                                    Un administrador verificara su pago
                                <?php } ?>
                                <?php if ($pedido['estado'] === "Completado") { ?>
                                    <h1>¡Gracias por su compra!</h1>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($pedido['estado'] === "Completado"){?>
                                    <a class="btn-descargar" href="index.php?controller=pedido&action=descargarFactura&ID_Pedido=<?php echo $pedido['ID_Pedido']; ?>">Descargar Factura</a>
                                <?php } else {?>
                                    Su orden todavia no esta preparada
                                <?php } ?>
                            </td>
                            <td>
                            <?php if($pedido['estado'] === "Completado") { ?>
                                El pedido fue completado   
                            <?php } if($pedido['estado'] === "Procesando Pago"){?>
                                El pago esta siendo procesado
                            </form>
                            <?php } if($pedido['estado'] != "Procesando Pago" && $pedido['estado'] != "Completado"){?>
                                <form action="index.php?controller=pedido&action=eliminarPedido" method="post">
                                <input type="hidden" name="ID_Pedido" value="<?php echo $pedido['ID_Pedido'] ?>">
                                <input type="submit" value="Eliminar">
                            <?php }?>
                            </td>
                            </tr>
                        <?php }?>
                    <?php }?>
                    
                </tbody>
                <tfoot></tfoot>
            </table>
        </section>
    </main>
    <?php include 'view/footer.php' ?>
</body>
</html>