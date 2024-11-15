<?php include 'view/adminView/general/cabecera_privada_admin.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/modificarEstadoPedido.css">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Modificar Usuario</title>
</head>
<body>
    
<?php include 'view/header.php'; ?>

<main>
    <section>
        <h3>Administradores</h3>
    <table border="1">
        <tbody>
        <tr>
            <th>ID Admin</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>ID Usuario</th>
            <th>Degradar</th>
        </tr>
        <tr>
            <?php foreach ($Admins as $Admin): ?>

                    <tr>
                        <td><?php echo $Admin['ID']; ?></td>
                        <td><?php echo $Admin['nombre']; ?></td>
                        <td><?php echo $Admin['email']; ?></td>
                        <td><?php echo $Admin['rol']; ?></td>
                        <td><?php echo $Admin['id_usuario']; ?></td>
                        <?php if($Admin['rol'] != "superAdmin"){?>
                        <td>
                            <?php if($_SESSION['rol'] === "superAdmin"){?>
                            <form action="index.php?controller=user&action=quitarAdmin" method="post">
                            <input type="hidden" name="ID_Administrador" value="<?php echo $Admin['ID']; ?>">
                            <input type="hidden" name="ID_Usuario" value="<?php echo $Admin['id_usuario']; ?>">
                            <input type="submit" value="Modificar">
                            </form>
                            <?php } else{ ?>
                                <?php echo 'No Tienes los permisos suficientes'; ?>   
                            <?php } ?>
                        </td>
                            
                        <?php } else{ ?>
                            <td>
                            <?php echo 'No se puede Degradar'; ?>
                            </td>
                        <?php } ?>
                        
                    </tr>
            <?php endforeach; ?>
        </tr>
        </tbody>

        </table>
    </section>
    <section>
        <h3>Usuarios</h3>
        <table border="1">
        <tbody>
        <tr>
            <td>ID</td>
            <td>Nombre</td>
            <td>Email</td>
            <td>Rol</td>
            <td>Promover</td>
        </tr>
        <tr>
            <?php foreach ($Usuarios as $Usuario): ?>

                    <tr>
                        <td><?php echo $Usuario['ID']; ?></td>
                        <td><?php echo $Usuario['nombre']; ?></td>
                        <td><?php echo $Usuario['email']; ?></td>
                        <td><?php echo $Usuario['rol']; ?></td>
                        <?php if($_SESSION['rol'] === "superAdmin"){?>
                        <td>
                            <form action="index.php?controller=user&action=verUsuarios" method="post">
                            <input type="hidden" name="ID_Usuario" value="<?php echo $Usuario['ID']; ?>">
                            <input type="submit" value="Modificar">
                            </form>
                        </td>
                        <?php } else{ ?>
                            <td>
                            <?php echo 'No tienes permisos suficientes'; ?>
                            </td>
                        <?php } ?>
                        
                    </tr>
            <?php endforeach; ?>
        </tr>
        </tbody>

        </table>
    </section>
</main>

</body>
</html>