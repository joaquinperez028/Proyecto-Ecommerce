<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarEstadoPedido.css">
    <title>Confirmar Pago</title>
</head>
<body>
<?php include 'view/header.php'; ?>
<main>
    <section>
        <table border="1">

            <thead>
            <tr>
                <th colspan="6">Pagos a Confirmar</th>
            </tr>
            <tr>
                <th>ID Pedido</th>
                <th>ID Orden</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Editar Estado</th>
                <th>Enviar</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pedidos as $pedido){ ?>
                <tr>
                <form action="index.php?controller=pedido&action=modificarOrdenAdmin" method="post">
                <td><?php echo $pedido['ID_Pedido']; ?></td>
                <td><?php echo $pedido['ID_Orden']; ?></td>
                <td><?php echo $pedido['email']; ?></td>
                <td><?php echo $pedido['estado']; ?></td>
                <td>
                    <input type="hidden" name="ID_Pedido" value="<?php echo $pedido['ID_Pedido']; ?>">
                    <select name="estado">
                        <option value="Completado">Completado</option>
                        <option value="Pago Rechazado">Pago Rechazado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Actualizar">
                </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </section>
    <section>
        <table border="1">

            <thead>
            <tr>
                <th colspan="6">Pedidos Completados</th>
            </tr>
            <tr>
                <th>ID Pedido</th>
                <th>ID Orden</th>
                <th>Email</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pedidosCompletados as $pedido){ ?>
                <tr>
                <form action="index.php?controller=pedido&action=modificarOrdenAdmin" method="post">
                <td><?php echo $pedido['ID_Pedido']; ?></td>
                <td><?php echo $pedido['ID_Orden']; ?></td>
                <td><?php echo $pedido['email']; ?></td>
                <td><?php echo $pedido['estado']; ?></td>
                <?php }?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>