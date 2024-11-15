<?php

require 'model/pedido_model.php';

if(session_status() === PHP_SESSION_NONE) session_start();

function verPedidos(){

    $pedido = new Pedido();

    $pedidos = $pedido -> obtenerPedidos($_SESSION['user_id']);

    include 'view/privado/pedidosEnProgreso_view.php';

}

function generarPedido(){
    
    $pedido = new Pedido();

    $generarPedido = $pedido->generarPedido(htmlspecialchars($_POST['total']), htmlspecialchars($_POST['ID_Carrito']));

    if($generarPedido){
        header('Location: index.php?controller=pedido&action=verPedidos');
    }
    else{
        echo '<meta http-equiv="refresh" content="0;url=index.php?controller=carrito&action=verCarrito">';
    }

}

function rellenarPedido(){

    $pedido = new Pedido();

    $idPedido = $pedido -> obtenerIdPedido(htmlspecialchars($_POST['ID_Pedido']));
    $infoPedido = $pedido -> obtenerPedido(htmlspecialchars($_POST['ID_Pedido']));
    $precioTotal = $pedido->obtenerPrecioTotal(htmlspecialchars($_POST['ID_Pedido']));

    include 'view/privado/crearOrdenCompra_view.php';

}

function completarPedido(){

    $pedido = new Pedido();

    $pedidoCompletado = $pedido ->crearOrden(htmlspecialchars($_POST['nombre']), htmlspecialchars($_POST['apellido']), htmlspecialchars($_POST['cedula']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['departamento']), htmlspecialchars($_POST['Ciudad']), htmlspecialchars($_POST['Direccion']), htmlspecialchars($_POST['telefono']), htmlspecialchars($_POST['opcionPago']), htmlspecialchars($_POST['opcionEnvio']), htmlspecialchars($_POST['ID_Pedido']), htmlspecialchars($_POST['ID_Usuario']));

    $actualizarEstado = $pedido -> actualizarEstadoEsperandoPago(htmlspecialchars($_POST['ID_Pedido']));

    if($pedidoCompletado['status'] == "true"){
        header('Location: index.php?controller=pedido&action=verPedidos');
    }
    else {
        echo 'Hubo un problema al rellenar el formulario';
        $idPedido = $pedido -> obtenerIdPedido(htmlspecialchars($pedidoCompletado['idPedido']));
        $infoPedido = $pedido -> obtenerPedido(htmlspecialchars($pedidoCompletado['idPedido']));
        $precioTotal = $pedido->obtenerPrecioTotal(htmlspecialchars($pedidoCompletado['idPedido']));
        include('view/privado/crearOrdenCompra_view.php');
    }
}

function eliminarPedido(){

    $pedido = new Pedido();

    $pedidoBorrado = $pedido->borrarPedido(htmlspecialchars($_POST['ID_Pedido']));

    if($pedidoBorrado){
        header('Location: index.php?controller=pedido&action=verPedidos');
    }else{
        echo 'Se produjo un error a la hora de borrar el pedido';
    }
}

function actualizarPago(){
    $pedido = new Pedido();

    $pedidoActualizado = $pedido->actualizarPago(htmlspecialchars($_POST['ID_Pedido']));

    if($pedidoActualizado){
        header('Location: index.php?controller=pedido&action=verPedidos');
    } else{
        echo 'Se produjo un error a la hora de actualizar el estado del pedido';
    }
}

function modificarOrdenes(){
    $pedido = new Pedido();

    $pedidos = $pedido->obtenerOrdenes();
    $pedidosCompletados = $pedido->obtenerOrdenesCompletadas();

    include 'view/adminView/confirmarPago_view.php';
}

function modificarOrdenAdmin(){

    $pedido = new Pedido();

    $pedidoActualizado = $pedido->actualizarEstadoAdmin(htmlspecialchars($_POST['estado']), htmlspecialchars($_POST['ID_Pedido']));

    if($pedidoActualizado){
        header('Location: index.php?controller=pedido&action=modificarOrdenes');
    } else{
        echo 'Error al modificar el producto';
    }
}

function descargarFactura(){
    $pedido= new Pedido();

    $factura = $pedido->descargarFactura(htmlspecialchars($_GET['ID_Pedido']));

    if($factura){
        header('Location: index.php?controller=pedido&action=verPedidos');
    }
    else{
        echo 'hubo un problema al descargar la factura';
    }
}