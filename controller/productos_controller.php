<?php
require 'model/productos_model.php';

function crearCategoria() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto = new Productos();
        $nuevaCategoria = $producto->crearCategoria(htmlspecialchars($_POST['nombreCategoria']));

        if ($nuevaCategoria) {
            header('Location: index.php?controller=productos&action=crearCategoria');
            exit;
        } else {
            $categorias = $producto->obtenerCategorias();
            include 'view/adminView/agregarCategoria_view.php';
            echo 'Esa categoria ya existe';
        }
    } else {
        $producto = new Productos();
        $categorias = $producto->obtenerCategorias();
        include 'view/adminView/agregarCategoria_view.php';
    }
}

function editarCategoria(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto = new Productos();
        
        $categoria = $producto -> obtenerCategoria(htmlspecialchars($_POST['ID_Categoria']));

        include 'view/adminView/editarCategoria_view.php';
    }
    else{
        echo 'metodo ingresado incorrecto';
    }
}

function actualizarCategoria(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto = new Productos();

        $catModificada = $producto -> actualizarCategoria(htmlspecialchars($_POST['catModificada']), htmlspecialchars($_POST['ID_Categoria']));
        if($catModificada){
            echo 'Categoria modificada con exito.';
            echo '<meta http-equiv="refresh" content="2;url=index.php?controller=productos&action=crearCategoria">';
        }
        else{
            echo 'hubo un error en la modificacion';
            echo '<meta http-equiv="refresh" content="2;url=index.php?controller=productos&action=crearCategoria">';
        }
    }
    else{
        echo 'metodo ingresado incorrecto';
    }
}

function eliminarCategoria(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto = new Productos();
        
        $categoriaEliminada = $producto -> eliminarCategoria(htmlspecialchars($_POST['ID_Categoria']));

        if($categoriaEliminada){
            header('Location: index.php?contorller=productos&action=crearCategoria');
        }
        else{
            echo 'no se puedo eliminar la categoria';
        }
    }
    else{
        echo 'metodo ingresado incorrecto';
    }
}

function agregarProducto() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {

        if(session_status() === PHP_SESSION_NONE) session_start();

        $producto = new Productos();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $categorias = $producto->obtenerCategorias();
            include 'view/adminView/agregarProducto_view.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_FILES['imagenesProducto']) && $_FILES['imagenesProducto']['error'][0] == 0) {

                // Capturar el tipo de stock seleccionado
                $tipoStock = $_POST['tipoStock']; // "fisico" o "produccion"

                // Si es stock físico, capturar las cantidades de stock para cada talle
                $stockPorTalle = [];
                if ($tipoStock === 'fisico') {
                    foreach ($_POST['talles'] as $talle) {
                        $stockPorTalle[$talle] = $_POST['stock_'.$talle] ?? 0; // Capturar la cantidad para cada talle
                    }
                }

                if ($tipoStock === 'produccion') {
                    foreach ($_POST['talles'] as $talle) {
                        $stockPorTalle[$talle] = $talle; // Capturar la cantidad para cada talle
                    }
                }

                $resultado = $producto->agregarProductoConImagenes(
                    htmlspecialchars($_POST['nombreProducto']),
                    htmlspecialchars($_POST['categoriaProducto']),
                    $_POST['colores'] ?? [],
                    $_POST['talles'] ?? [],
                    htmlspecialchars($_POST['precioProducto']),
                    htmlspecialchars($_POST['descripcionProducto']),
                    $_FILES['imagenesProducto'],
                    htmlspecialchars($_POST['idAdmin']),
                    $tipoStock,
                    $stockPorTalle
                );

                if ($resultado) {
                    header('Location: index.php?controller=productos&action=verProductosAdmin');
                } else {
                    echo 'Error al agregar el producto.';
                }

            } else {
                echo 'No seleccionó una imagen para el producto.';
            }

        }
    } else {
        echo 'Método ingresado incorrecto';
    }
}


function verProductosAdmin() {

    if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto = new Productos();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productos = $producto->obtenerProductos();
            include 'view/adminView/productosAdmin_view.php';
        }

    }

}

function eliminarProducto() {

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $producto = new Productos();

        $eliminarProducto = $producto -> eliminarProducto(htmlspecialchars($_POST['ID_Producto']));

        if($eliminarProducto){

        header('Location: index.php?controller=productos&action=verProductosAdmin');
            
        }
        else {
            echo 'error';
        }
    }

}

function modificarProducto() {

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $producto = new Productos();

        $productoInfo = $producto -> obtenerProductoUnico(htmlspecialchars($_POST['ID_Producto']));

        include 'view/adminView/modificarProducto_view.php';

    } else {
        echo 'metodo ingresado incorrecto';
    }

}

function actualizarProducto() {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $producto = new Productos();

        $actualizarProducto = $producto -> actualizarProducto(htmlspecialchars($_POST['ID_Producto']), htmlspecialchars($_POST['opcionModificada']), htmlspecialchars($_POST['modificacion']));

        if ($actualizarProducto){

            
            echo'<script> alert("Producto modificado con exito") </script>';
            
            echo '<meta http-equiv="refresh" content="0;url=index.php?controller=productos&action=verProductosAdmin">';

        }
        else{
            echo'No se pudo modificar el producto';
        }
    } else {
        echo 'metodo ingresado incorrecto';
    }
}

function modificarImagen() { 
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $producto = new Productos();

    $imagenesProducto = $producto -> obtenerImagenesProductoAModificar(htmlspecialchars($_POST['ID_Producto']));

    $idProd = $producto -> obtenerIDProducto(htmlspecialchars($_POST['ID_Producto']));

    include 'view/adminView/modificarImagenProducto_view.php';

   } else {
    echo 'metodo ingresado incorrecto';
   } 
}

function eliminarImagenProducto(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $producto = new Productos();

        $imagenEliminada = $producto -> eliminarImagenUnica(htmlspecialchars($_POST['ID_Imagen']), htmlspecialchars($_POST['ID_Producto']));

        if ($imagenEliminada){
            $imagenesProducto = $producto -> obtenerImagenesProductoAModificar(htmlspecialchars($_POST['ID_Producto']));

            include 'view/adminView/modificarImagenProducto_view.php';

            echo 'imagen eliminada con exito';
        }else{
            echo 'no se pudo eliminar la imagen';
        }

    }
    else {
        echo 'metodo ingresado incorecto';
    }
}

function agregarImagenNueva(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $producto = new Productos();

        // Verificar si el archivo fue enviado correctamente
        if (isset($_FILES['imagenNueva']) && $_FILES['imagenNueva']['error'] === 0) {

            $imagen = $producto->agregarImagenProducto(htmlspecialchars($_POST['ID_Producto']), $_FILES['imagenNueva']);
            if ($imagen) {

                $imagenesProducto = $producto -> obtenerImagenesProductoAModificar(htmlspecialchars($_POST['ID_Producto']));

                include 'view/adminView/modificarImagenProducto_view.php';

                echo 'imagen agregada con exito';
            } else {
                echo 'Hubo un error al agregar la imagen.';
            }
        } else {
            echo 'Error al subir la imagen.';
        }
    } else {
        echo 'Método ingresado incorrecto';
    }
}

function modificarCategoria(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $producto = new Productos();
        
        $productoInfo = $producto -> obtenerProductoUnico(htmlspecialchars($_POST['ID_Producto']));
        $categorias = $producto -> obtenerCategorias();
        
        include 'view/adminView/modificarCategoria_view.php';
    }
    else{
        echo 'metodo ingresado incorrecto';
    }
}

function catModificada(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $producto = new Productos();

        $catModificada = $producto -> modificarCategoria(htmlspecialchars($_POST['categoriaEditada']), htmlspecialchars($_POST['ID_Producto']));

        if($catModificada){
            header('Location: index.php?controller=productos&action=verProductosAdmin');
        } else{
            echo 'No se pudo modificar la categoria';
        }
    }
    else{
        echo 'metodo ingresado incorrecto';
    }
}

function verProductos() {
    

        $producto = new Productos();

        $productos = $producto->obtenerProductosEImagen();

        include 'view/verProductos_view.php';


}

function verProductoUnico() {
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $producto = new Productos();

        $productoInfo = $producto->obtenerProductoUnico(htmlspecialchars($_POST['ID_Producto']));
        $imagenUnica = $producto -> obtenerPrimerImagenUnica(htmlspecialchars($_POST['ID_Producto']));
        $imagenInfo = $producto->obtenerImagenProductoUnico(htmlspecialchars($_POST['ID_Producto']));


        $tallesString = $productoInfo['Talles'];
        $tallesCantidad = $productoInfo['cantidad'];
        $coloresString = $productoInfo['Color']; 

        $tallesArray = explode(',', $tallesString);
        $cantidadArray = explode(',', $tallesCantidad);
        $coloresArray = explode(',', $coloresString);


        include 'view/ProductoUnico_view.php';


    } else {
        echo 'metodo ingresado incorrecto';
    }
}

function quitarProductoDeProduccion(){

    $producto = new Productos();
    $actualizarEstado = $producto -> quitarProduccion(htmlspecialchars($_POST['ID_Producto']));
    
    header('Location: index.php?controller=productos&action=verProductosAdmin');

}

function AgregarProductoAProduccion(){

    $producto = new Productos();
    $actualizarEstado = $producto -> agregarAProduccion(htmlspecialchars($_POST['ID_Producto']));

    header('Location: index.php?controller=productos&action=verProductosAdmin');
    

}

function verInicio(){

    $producto = new Productos();

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $generarRanking = $producto->generarRanking();
        $ranking = $producto->obtenerProductosRanking();
        
        include 'view/paginaInicio_view.php';
    }
}

?>