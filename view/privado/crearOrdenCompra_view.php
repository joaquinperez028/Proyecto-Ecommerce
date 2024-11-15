<?php include 'view/privado/general/cabecera_privada.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/ordenCompra.css">
    <title>Orden Compra</title>
</head>
<body>
    <?php include 'view/header.php'; ?>

    <main>
        <section class="contenedorPrincipal">
            
            <form class="formOrdenCompra" action="index.php?controller=pedido&action=completarPedido" method="post">
                <div class="titulo">
                <h1>Informacion Personal</h1>
                </div>

                <div class="informacion">
                <label for="Nombre">Nombre: </label>
                <input type="text" name="nombre" id="Nombre" minlength="3" maxlength="15" required>
                <label for="Apellido">Apellido: </label>
                <input type="text" name="apellido" id="Apellido" minlength="3" maxlength="15" required>
                </div>
                <div class="informacion">
                    <label for="CI">Cedula de Identidad: </label>
                    <input type="number" name="cedula" id="CI" minlength="8" maxlength="8" required>
                </div>
                <div class="informacion">
                  <label for="Correo">Correo Electronico: </label>  <?php echo $_SESSION['email'] ?>
                </div>
                <div class="Departamentos">
                <select name="departamento" id="">
                    <option value="Artigas">Artigas</option>
                    <option value="Canelones">Canelones</option>
                    <option value="Cerro Largo">Cerro Largo</option>
                    <option value="Colonia">Colonia</option>
                    <option value="Durazno">Durazno</option>
                    <option value="Flores">Flores</option>
                    <option value="Florida">Florida</option>
                    <option value="Lavalleja">Lavalleja</option>
                    <option value="Maldonado">Maldonado</option>
                    <option value="Montevideo">Montevideo</option>
                    <option value="Paysandu">Paysandú</option>
                    <option value="RioNegro">Río Negro</option>
                    <option value="Rivera">Rivera</option>
                    <option value="Rocha">Rocha</option>
                    <option value="Salto">Salto</option>
                    <option value="SanJose">San José</option>
                    <option value="Soriano">Soriano</option>
                    <option value="Tacuarembo">Tacuarembó</option>
                    <option value="TreintaYTres">Treinta y Tres</option>
                </select>
                </div>
                <div class="informacion">
                    <label for="Ciudad">Ciudad: </label>
                    <input type="text" name="Ciudad" id="" minlength="3" maxlength="15" required>
                    <label for="Direccion">Direccion: </label>
                    <input type="text" name="Direccion" id="" minlength="3" maxlength="15" required>
                </div>
                <div class="informacion">
                    <label for="Telefono">Telefono: </label>
                    <input type="tel" name="telefono" id="" minlength="8" maxlength="9" required>
                </div>
                <div class="informacion">
                    <h4>Seleccione el metodo de envio:</h4>
                <label for="opcionEnvio">
                    <input type="radio" name="opcionEnvio" value="RetiroEnLocal" required>
                    Retiro en el local.
                 </label><br>
                <label for="opcionEnvio">
                    <input type="radio" name="opcionEnvio" value="EnvioDac" required>
                    Envio por DAC. <span>(Envio no incluido en el precio final.)</span>
                </label><br>
                </div>
                <div class="informacion">
                <h4>Seleccione el metodo de Pago:</h4>
                <label for="opcionPago">
                    <input type="radio" name="opcionPago" value="PagoLocal" required>
                    Pago al retirar. <span>(Solo es valido si lo retira en el local)</span>
                 </label><br>
                <label for="opcionPago">
                    <input type="radio" name="opcionPago" value="Transferencia" required>
                    Pago por transferencia. <span>(Numero de cuenta BROU: 12345678-00001)</span>
                </label><br>
                </div>
                <input type="hidden" name="email" value="<?php echo $_SESSION['email']?>">
                <input type="hidden" name="ID_Usuario" value="<?php echo $_SESSION['user_id']?>">
                <input type="hidden" name="ID_Pedido" value="<?php echo $idPedido['ID_Pedido']?>">
                <div class="btnE">
                <input type="submit" value="Enviar">
                </div>
  
            </form>
            <aside class="detallesPedido">
                <div class="titulo">
                <h1>Pedido</h1>
                </div>
                <table border="1">
                    
                <thead class=encabezadoTabla>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total Producto</th>
                </thead>
                <tbody class=contenidoTabla>
                    <?php foreach($infoPedido as $producto) {?>
                    <tr>
                    <div class="infopedido">
                            <td><?php echo $producto['Nombre'] ?></td>
                            <td><?php echo $producto['cantidad'] ?></td>
                            <td>$<?php echo $producto['precioUnitario'] ?></td>
                            <td>$<?php echo $producto['Total'] ?></td>
                    </div>
                    </tr>
                <?php }?>
                </tbody>
                <tfoot class=contenidoTabla>
                <tr>
                    <td colspan="4">Subtotal: <?php echo $precioTotal['Total'] ?>  </td>
                </tr>
                <tr>
                    <td colspan="4">IVA: <?php echo $precioTotal['Total']*0.22 ?></td>
                </tr>
                <tr>
                <td colspan = 4> <h3>Precio total: <?php echo $precioTotal['Total'] + $precioTotal['Total'] * 0.22 ?></h3></td>
                </tr>
                <tr>
                <td colspan = 4> Impuestos aplicados en el precio total</td>
                </tr>

                </tfoot>
                </table>
            </aside>
        </section>
    </main>
    <script src="assets/js/ordenPedido.js"></script>

    <?php include 'view/footer.php' ?>
</body>
</html>