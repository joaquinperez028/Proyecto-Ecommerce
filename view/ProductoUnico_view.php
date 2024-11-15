<?php if(empty($productoInfo['ID_Producto'])) header ('Location: index.php?controller=productos&action=verProductos'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navBar.css">
    <link rel="stylesheet" href="assets/css/styleProductoUnico.css">
    <link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
    <title><?php $productoInfo['Nombre']; ?></title>
</head>
<body>

    <?php include 'header.php' ?>

    <main>
        <section>
            <div class="contenedorPrincipal">
            
                <div class="contenedorImagenes">
                    <div class="imagenPrincipal">
                        <img id="imagenPrincipal" src="<?php echo $imagenUnica['ruta_imagen'] ?>" alt="imagenPrincipal">    
                    </div>
                    <div class="imagenesSecundarias">   
                        <?php foreach($imagenInfo as $imagen){ ?>
                            <img src="<?php echo $imagen['ruta_imagen'] ?>" alt="imagenProducto" class="secundaria">
                        <?php } ?>
                    </div>
                </div>
                

                <div class="contenedorInformacion">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="index.php?controller=carrito&action=agregarProductoCarrito" method="post">
                    <input type="hidden" name="ID_Producto" value=" <?php echo $productoInfo['ID_Producto']?>">
                    <input type="hidden" name="Precio" value="<?php echo $productoInfo['Precio'] ?>">
                    <?php endif;?>
                    <h2> <?php echo $productoInfo['Nombre'] ?> </h2> 
                    <h3> Precio: <?php echo '$'.$productoInfo['Precio'] ?> </h3>
                    <label for="talles">Seleccione Talle:</label>
                    <select name="talles" id="talles">
                        <?php 
                            if($productoInfo['tipoStock'] === "fisico"){
                            foreach ($tallesArray as $index => $talle) {
                                $cantidad = $cantidadArray[$index];
                                if(!empty($cantidad))
                                echo "<option value='$talle'> $talle ($cantidad)</option>";
                            }
                            }
                            else{
                                foreach ($tallesArray as $talle) {
                                    echo "<option value='$talle'> $talle </option>";
                                }
                            }
                        ?>
                    </select>
                    <label for="cantidad">Seleccione la cantidad deseada:</label>
                    <select name="cantidad" id="cantidad">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <label for="talles">Seleccione Color:</label>
                    <select name="colores" id="colores">
                        <?php foreach ($coloresArray as $color): ?>
                            <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p> <?php echo $productoInfo['Descripcion'] ?> </p>
                        <?php if($productoInfo['estado'] === "Fuera de produccion") { ?>
                            <form action="" method="post">
                            <input type="submit" value="Producto descontinuado">
                            </form>
                        <?php }else{ ?>
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            
                            <input type="submit" value="Agregar Al Carrito">
                        </form>

                        <?php } else { ?>
                            <a href="index.php?controller=user&action=verLogin" id="noLogueado">Debe loguearse antes de agregar un producto</a>
                        <?php } }?>
                
                </div>
            </div>
        </section>
    </main>
        <?php include 'footer.php' ?>
    <script src="assets/js/productoUnico.js" defer></script>
</body>
</html>