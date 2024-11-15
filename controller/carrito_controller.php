<?php
require 'model/carrito_model.php';

if(session_status() === PHP_SESSION_NONE) session_start();

function verCarrito(){

    if(session_status() === PHP_SESSION_NONE) session_start();

    $carrito = new Carrito();
    $numeroArticulosEnCarrito = $carrito -> cantidadProductosEnCarrito();
    $productosEnCarrito = $carrito->obtenerProductosEnCarrito($_SESSION['user_id']);
    $carritoID = $carrito->obtenerIdCarrito($_SESSION['user_id']);

    include 'view/privado/carrito_view.php';
}

function crearCarrito(){

    $carrito = new Carrito();
    
    $crearCarrito = $carrito -> crearCarrito($_SESSION['user_id']); 
    $productosEnCarrito = $carrito -> cantidadProductosEnCarrito();

    if($crearCarrito && $productosEnCarrito)
    header('Location: index.php?controller=productos&action=verInicio');
    else
    header('Location: index.php?controller=user&action=consultarDatos');

}

function agregarProductoCarrito(){

    $carrito = new Carrito();

    $agregarProducto= $carrito -> agregarProductoCarrito(htmlspecialchars($_POST['ID_Producto']), htmlspecialchars($_POST['Precio']), htmlspecialchars($_POST['talles']), htmlspecialchars($_POST['cantidad']), htmlspecialchars($_POST['colores']));

    if($agregarProducto){
        header('Location: index.php?controller=carrito&action=verCarrito');
    }
    else{
        echo 'hubo un error al agregar el producto';
    }

}

function eliminarDelCarrito(){
    
    $carrito = new Carrito();

    $eliminarProducto = $carrito -> eliminarDelCarrito(htmlspecialchars($_POST['ID_Producto']));

    if($eliminarProducto){
        header('Location: index.php?controller=carrito&action=verCarrito');
    }
    else{
        echo 'hubo un error a la hora de eliminar el producto';
    }

}

function vaciarCarrito(){
    
    $carrito = new Carrito();

    $vaciarCarrito = $carrito -> vaciarCarrito($_SESSION['user_id']);

    if($vaciarCarrito){
        header('Location: index.php?controller=carrito&action=verCarrito');
    }
    else{
        echo 'hubo un error a la hora de vaciar el carrito';
    }

}