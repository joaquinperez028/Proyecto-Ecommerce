<?php
require "config.php";

class Carrito {

    private $pdo;
    //PDO (PHP Data Objects) es una extensión de PHP que proporciona una interfaz uniforme para acceder a bases de datos desde PHP
    // Constructor que recibe la conexión PDO como argumento
    public function __construct() {
        $this->pdo = getConnection();
    }

public function crearCarrito($ID_Usuario){

    $stmt = $this->pdo->prepare('SELECT ID_Carrito FROM carrito WHERE ID_Usuario = :id_usuario AND estado = "activo"');
    $stmt->execute(['id_usuario' => $ID_Usuario]);
    $carritoActivo = $stmt->fetch(PDO::FETCH_ASSOC);

    

    if(!empty($carritoActivo)){
        $_SESSION['carritoActivo'] = $carritoActivo['ID_Carrito'];
        return true;
        exit();
    }

    $crearCarrito = $this->pdo->prepare('INSERT INTO carrito (ID_Usuario, estado, fecha_creacion) VALUES (:id_usuario, "activo", NOW());');
    $crearCarrito->execute(['id_usuario' => $ID_Usuario]);

    $obtenerCarritoCreado = $this->pdo->prepare('SELECT ID_Carrito FROM carrito WHERE ID_Usuario = :id_usuario AND estado = "activo"');
    $obtenerCarritoCreado->execute(['id_usuario' => $ID_Usuario]);
    $carritoNuevo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['carritoActivo'] = $carritoNuevo['ID_Carrito'];

    return true;
    
}

public function cantidadProductosEnCarrito(){
    $carrito = $this->pdo->prepare('SELECT COUNT(u.ID_unioncarritoproducto) AS "articulosEnCarrito" 
    FROM carrito as c
    INNER JOIN unioncarritoproducto AS u
    ON u.ID_Carrito = c.ID_Carrito
    WHERE c.ID_Usuario = :id_usuario && c.ID_Carrito = :id_carrito');       
    $carrito->execute(['id_usuario' => $_SESSION['user_id'], 'id_carrito' => $_SESSION['carritoActivo']]);
    $carrito = $carrito->fetch(PDO::FETCH_ASSOC);

    $_SESSION['articulosEnCarrito'] = $carrito['articulosEnCarrito'];

    return true;
}

public function agregarProductoCarrito($ID_Producto, $precio, $talle, $cantidad, $color){

    $CarritoID = $this->pdo->prepare('SELECT ID_Carrito FROM carrito WHERE ID_Usuario = :id_usuario AND estado = "activo" ');
    $CarritoID->execute(['id_usuario' => $_SESSION['user_id']]);
    $CarritoID = $CarritoID->fetch(PDO::FETCH_ASSOC);

    $agregarProducto = $this->pdo->prepare('INSERT INTO unioncarritoproducto (cantidad, color, talle, precioUnitario, ID_Carrito, ID_Productos) VALUES (:cantidad, :color, :talle, :precioUnitario, :ID_Carrito, :ID_Productos)');
    $agregarProducto->execute(['cantidad' => $cantidad, 'color' => $color, 'talle' => $talle, 'precioUnitario' => $precio, 'ID_Carrito' => $CarritoID['ID_Carrito'], 'ID_Productos' => $ID_Producto]);
    
    return true;

}

public function obtenerProductosEnCarrito($ID_Usuario){

    $obtenerCarritoActivo = $this->pdo->prepare('SELECT c.ID_Carrito 
    FROM carrito as c 
    WHERE estado = "activo" && ID_Usuario = :ID_usuario
    GROUP BY c.ID_Usuario');
    $obtenerCarritoActivo -> execute(['ID_usuario' => $ID_Usuario]);
    $obtenerCarritoActivo = $obtenerCarritoActivo->fetch(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare('SELECT i.ruta_imagen, p.Nombre, u.cantidad, u.color, u.talle, u.precioUnitario, (u.precioUnitario * u.cantidad) AS precioTotal, u.ID_unionCarritoProducto AS "ID_Producto" 
    FROM unioncarritoproducto as u 
    INNER JOIN producto as p 
    ON p.ID_Producto = u.ID_Productos 
    INNER JOIN imagenproducto as i 
    ON i.producto_id = u.ID_Productos 
    INNER JOIN carrito as c 
    ON c.ID_Carrito = u.ID_Carrito 
    WHERE c.ID_Carrito = :id_carrito
    GROUP BY u.ID_unionCarritoProducto');
    $stmt->execute(['id_carrito' => $obtenerCarritoActivo['ID_Carrito']]);
    $productosEnCarrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $productosEnCarrito;
}

public function eliminarDelCarrito($ID_Producto){
    $stmt = $this->pdo->prepare('DELETE FROM unioncarritoproducto WHERE ID_unionCarritoProducto = :ID_unionCarritoProducto');
    $stmt->execute(['ID_unionCarritoProducto' => $ID_Producto]);

    return true;
}

public function vaciarCarrito($ID_Usuario){

    $stmt = $this->pdo->prepare('DELETE u.* 
    FROM carrito as c 
    INNER JOIN unioncarritoproducto as u
    ON u.ID_Carrito = c.ID_Carrito
    WHERE c.ID_Usuario = :ID_Usuario');
    $stmt->execute(['ID_Usuario' => $ID_Usuario]);
    
    return true;

}

public function obtenerIdCarrito($ID_Usuario){
    $carrito = $this->pdo->prepare( 'SELECT car.ID_Carrito AS ID_Carrito
        FROM clientes as c
        INNER JOIN carrito as car
        ON car.ID_Usuario = c.ID
        WHERE c.ID = :id_usuario && car.estado = "activo"');
    $carrito->execute(['id_usuario' => $ID_Usuario]);
    $carrito = $carrito->fetch(PDO::FETCH_ASSOC);

    return $carrito;
}


}