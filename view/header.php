<link rel="stylesheet" href="assets/css/navBar.css">

<header>
    <nav>
        <button id="toggleSidebar">☰</button>
        
        <div id="sidebar" class="sidebar">
        <a href="#" class="closebtn" id="closeSidebar">&times;</a>
        <a href="index.php?controller=productos&action=verInicio">Inicio</a>
        <a href="index.php?controller=productos&action=verProductos">Productos</a>
        <?php 
        if(session_status() === PHP_SESSION_NONE) session_start();
         if (isset($_SESSION['user_id'])) { ?>
            <h3 id="opcionesAdmin">Opciones Usuario</h3>
            <a href="index.php?controller=pedido&action=verPedidos">Mis Pedidos</a>
            <a href="index.php?controller=user&action=verContacto">Contacta con nosotros</a>
            <a href="index.php?controller=user&action=logout">Cerrar sesión</a>
            <?php
            if ($_SESSION['rol'] === "Admin" || $_SESSION['rol'] === "superAdmin") {?>
            <h3 id="opcionesAdmin">Opciones Administrador</h3>
            <a href="index.php?controller=productos&action=verProductosAdmin">Lista Productos</a>
            <a href="index.php?controller=productos&action=crearCategoria">Agregar Categoria</a>
            <a href="index.php?controller=productos&action=agregarProducto">Agregar Producto</a>
            <a href="index.php?controller=pedido&action=modificarOrdenes">Confirmar Pagos</a>
            <a href="index.php?controller=user&action=verUsuarios">Usuarios</a>
            

            <?php } ?>
            </div>
        <?php  } else {  ?>  

        <a href="index.php?controller=user&action=verLogin">Loguearse</a>
        <a href="index.php?controller=user&action=verRegistro">Registrarse</a>
        </div>
        
        <?php  }  ?>

        <div class="logo">
            <a href="index.php?controller=productos&action=verInicio">
            <img src="assets/imagenes/logo.png" alt="logo" width="100%">
            </a>
        </div>
        
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="carrito">
            <a href="index.php?controller=carrito&action=verCarrito">
                🛒 <span id="contadorCarrito"><?php echo $_SESSION['articulosEnCarrito']?></span>
            </a>
            </div>
        <?php } else {?>
            <div class="carrito">
        </div>
        <?php }?>
    
    </nav>
</header>
<script src="assets/js/sidebar.js"></script>