<?php 

require "config.php";

class Pedido {

    private $pdo;
    //PDO (PHP Data Objects) es una extensión de PHP que proporciona una interfaz uniforme para acceder a bases de datos desde PHP
    // Constructor que recibe la conexión PDO como argumento
    public function __construct() {
        $this->pdo = getConnection();
    }

    public function obtenerIdPedido($idPedido){

        $ID_Pedido = $this -> pdo -> prepare('SELECT ID_Pedido FROM pedido WHERE ID_Pedido = :ID_Pedido');
        $ID_Pedido->execute(['ID_Pedido' => $idPedido]);
        $ID_Pedido = $ID_Pedido->fetch(PDO::FETCH_ASSOC);
        return $ID_Pedido;
    }

    public function obtenerPedidos($ID_Usuario){

        $pedidos = $this -> pdo -> prepare('SELECT p.ID_Pedido, p.ID_Carrito, p.Total , p.estado, GROUP_CONCAT(DISTINCT pr.Nombre ORDER BY pr.Nombre SEPARATOR ", ") AS Productos
        FROM pedido as p
        INNER JOIN unioncarritoproducto as u
        ON u.ID_Carrito = p.ID_Carrito
        INNER JOIN producto as pr
        ON pr.ID_Producto = u.ID_Productos
        WHERE p.ID_Usuario = :id_usuario
        GROUP BY p.ID_Pedido ');
        $pedidos->execute(['id_usuario' => $ID_Usuario]);
        
        $pedidos = $pedidos->fetchAll(PDO::FETCH_ASSOC);

        return $pedidos;
    }

    public function obtenerPedido($ID_Pedido){
        $pedido = $this->pdo->prepare('SELECT pr.Nombre, u.cantidad, u.precioUnitario, SUM(u.precioUnitario*u.cantidad) as Total
        FROM pedido as p
        INNER JOIN unioncarritoproducto as u
        ON u.ID_Carrito = p.ID_Carrito
        INNER JOIN producto as pr
        ON pr.ID_Producto = u.ID_Productos
        WHERE p.ID_Pedido = :id_pedido
        GROUP BY u.ID_Productos');
        $pedido->execute(['id_pedido' => $ID_Pedido]);
        $pedido = $pedido->fetchAll(PDO::FETCH_ASSOC);

        return $pedido;
    }

    public function obtenerPrecioTotal($ID_Pedido){
        $total = $this->pdo->prepare('SELECT p.Total
        FROM pedido as p
        WHERE p.ID_Pedido = :id_pedido');
        $total->execute(['id_pedido' => $ID_Pedido]);
        $total = $total->fetch(PDO::FETCH_ASSOC);
        return $total;
    }

    //RF-06
    public function generarPedido($total, $ID_Carrito){

        $obtenerCarrito = $this->pdo->prepare('
        SELECT u.cantidad AS cantidadSolicitada, u.ID_Productos, u.Talle 
        FROM carrito AS c 
        INNER JOIN unioncarritoproducto AS u 
        ON u.ID_Carrito = c.ID_Carrito 
        WHERE u.ID_Carrito = :ID_Carrito;
        ');
        $obtenerCarrito->execute(['ID_Carrito' => $ID_Carrito]);
        $carritoItems = $obtenerCarrito->fetchAll(PDO::FETCH_ASSOC);

        //RF-10
        foreach ($carritoItems as $item) {
            
            $cantidadSolicitada = $item['cantidadSolicitada'];
            $productoID = $item['ID_Productos'];
            $talle = $item['Talle'];

            $consultarTipoStock = $this->pdo->prepare('SELECT p.tipoStock FROM producto as p WHERE p.ID_Producto = :ID_Producto');
            $consultarTipoStock->execute(['ID_Producto' => $productoID]);
            $consultarTipoStock = $consultarTipoStock->fetchColumn();
            
            if($consultarTipoStock != "produccion"){
                $consultarStock = $this->pdo->prepare('
                SELECT cantidad 
                FROM stock 
                WHERE producto_id = :ID_Producto AND Talle = :Talle
            ');
            $consultarStock->execute(['ID_Producto' => $productoID, 'Talle' => $talle]);
            $stockActual = $consultarStock->fetchColumn(); //trae solo una cosa

            if ($cantidadSolicitada > $stockActual) {

                echo '<script>alert("cantidad solicitada superior al stock disponible")</script>';
                return false;
                exit();

            } else {
                
                $nuevoStock = $stockActual - $cantidadSolicitada;

                $actualizarStock = $this->pdo->prepare('
                    UPDATE stock 
                    SET cantidad = :nuevoStock 
                    WHERE producto_id = :ID_Producto AND Talle = :Talle
                ');
                $actualizarStock->execute([
                    'nuevoStock' => $nuevoStock,
                    'ID_Producto' => $productoID,
                    'Talle' => $talle
                ]);
            }
            }

        }


        $modificarCarrito = $this->pdo->prepare('UPDATE carrito SET estado = "Terminado" WHERE ID_Carrito = :id_carrito');
        $modificarCarrito->execute(['id_carrito' => $ID_Carrito]);
    
        $crearCarrito = $this->pdo->prepare('INSERT INTO carrito (ID_Usuario, estado, fecha_creacion) VALUES (:id_usuario, "activo", NOW());');
        $crearCarrito->execute(['id_usuario' => $_SESSION['user_id']]);
    
        $crearPedido = $this->pdo->prepare('INSERT INTO pedido (estado, total, ID_Carrito, ID_Usuario) VALUES ("En Proceso", :total, :id_carrito, :id_usuario)');
        $crearPedido->execute(['id_carrito' => $ID_Carrito, 'id_usuario' => $_SESSION['user_id'], 'total' => $total]);

        $obtenerCarritoCreado = $this->pdo->prepare('SELECT ID_Carrito FROM carrito WHERE ID_Usuario = :id_usuario AND estado = "activo"');
        $obtenerCarritoCreado->execute(['id_usuario' => $_SESSION['user_id']]);

        $carritoNuevo = $obtenerCarritoCreado->fetch(PDO::FETCH_ASSOC);
    
        $_SESSION['carritoActivo'] = $carritoNuevo['ID_Carrito'];

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

    private function corroborarCaracteresEspeciales($name) {

        $validacion = "/^[a-zA-Z\dñÑüÜáéíóúÁÉÍÓÚ\s]+$/"; // \d busca si tiene numeros del 0-9

        return preg_match($validacion, $name);
    }

    //RF-06
    public function crearOrden($nombre, $apellido, $cedula, $email, $departamento, $ciudad, $dirEnvio, $telefono, $tipoPago, $tipoEnvio, $ID_Pedido, $ID_Usuario){

        if(!self::corroborarCaracteresEspeciales($nombre)){
            echo 'Ingreso un caracter especial no permitido en el nombre';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        if(!self::corroborarCaracteresEspeciales($apellido)){
            echo 'Ingreso un caracter especial no permitido en el apellido';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        if(!self::corroborarCaracteresEspeciales($cedula)){
            echo 'Ingreso un caracter especial no permitido en la cedula';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        if(!self::corroborarCaracteresEspeciales($departamento)){
            echo 'Ingreso un caracter especial no permitido en el departamento';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }
        
        if(!self::corroborarCaracteresEspeciales($ciudad)){
            echo 'Ingreso un caracter especial no permitido en la ciudad';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        if(!self::corroborarCaracteresEspeciales($dirEnvio)){
            echo 'Ingreso un caracter especial no permitido en la direccion de envio';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        if(!self::corroborarCaracteresEspeciales($telefono)){
            echo 'Ingreso un caracter especial no permitido en el Telefono';
            return ['idPedido' => $ID_Pedido, 'status' => false];
            exit();
        }

        $ordenExistente= $this->pdo->prepare('SELECT o.ID_Orden FROM ordencompra AS o WHERE o.ID_Pedido = :id_pedido');
        $ordenExistente->execute(['id_pedido' => $ID_Pedido]);
        $ordenExistente = $ordenExistente->fetch(PDO::FETCH_ASSOC);

        if(!empty($ordenExistente)){
            return false;
            exit();
        }

        $orden = $this->pdo->prepare('INSERT INTO ordencompra (nombre, apellido, cedula, email, departamento, ciudad, dir_envio, telefono, tipo_pago, tipo_envio, ID_Pedido, ID_Usuario) VALUES (:nombre, :apellido, :cedula, :email, :departamento, :ciudad, :dir_envio, :telefono, :tipo_pago, :tipo_envio, :ID_Pedido, :ID_Usuario)');
        $orden->execute(['nombre'=> $nombre, 'apellido'=> $apellido, 'cedula'=> $cedula, 'email'=> $email, 'departamento'=> $departamento, 'ciudad'=> $ciudad, 'dir_envio'=> $dirEnvio, 'telefono' => $telefono, 'tipo_pago'=> $tipoPago, 'tipo_envio'=> $tipoEnvio, 'ID_Pedido' => $ID_Pedido, 'ID_Usuario' => $ID_Usuario]);

        return ['idPedido' => " ", 'status' => true];
    }

    public function borrarPedido($ID_Pedido) {

        $obtenerProductosPedido = $this->pdo->prepare('
            SELECT u.cantidad AS cantidadSolicitada, u.ID_Productos, u.Talle
            FROM unioncarritoproducto AS u
            INNER JOIN pedido AS p ON p.ID_Carrito = u.ID_Carrito
            WHERE p.ID_Pedido = :ID_Pedido
        ');
        $obtenerProductosPedido->execute(['ID_Pedido' => $ID_Pedido]);
        $productosPedido = $obtenerProductosPedido->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($productosPedido as $producto) {
            $cantidadSolicitada = $producto['cantidadSolicitada'];
            $productoID = $producto['ID_Productos'];
            $talle = $producto['Talle'];

            $consultarTipoStock = $this->pdo->prepare('SELECT p.tipoStock FROM producto as p WHERE p.ID_Producto = :ID_Producto');
            $consultarTipoStock->execute(['ID_Producto' => $ID_Pedido]);
            $consultarTipoStock = $consultarTipoStock->fetchColumn();

            if($consultarTipoStock != "produccion"){
    
            $actualizarStock = $this->pdo->prepare('
                UPDATE stock 
                SET cantidad = cantidad + :cantidadSolicitada
                WHERE producto_id = :ID_Producto AND Talle = :Talle
            ');
            $actualizarStock->execute([
                'cantidadSolicitada' => $cantidadSolicitada,
                'ID_Producto' => $productoID,
                'Talle' => $talle
            ]);

            }
        }
        
        $eliminarOrdenCompra= $this->pdo->prepare('
        DELETE o FROM ordencompra as o
        INNER JOIN pedido as p ON p.ID_Pedido = o.ID_Pedido
        WHERE p.ID_Pedido = :ID_Pedido
        ');
        $eliminarOrdenCompra->execute(['ID_Pedido' => $ID_Pedido]);

        $eliminarUnionCarritoProducto = $this->pdo->prepare('
            DELETE u FROM unioncarritoproducto AS u
            INNER JOIN pedido AS p ON p.ID_Carrito = u.ID_Carrito
            WHERE p.ID_Pedido = :ID_Pedido
        ');
        $eliminarUnionCarritoProducto->execute(['ID_Pedido' => $ID_Pedido]);
    
        $eliminarCarrito = $this->pdo->prepare('
            DELETE c FROM carrito AS c
            INNER JOIN pedido AS p ON p.ID_Carrito = c.ID_Carrito
            WHERE p.ID_Pedido = :ID_Pedido
        ');
        $eliminarCarrito->execute(['ID_Pedido' => $ID_Pedido]);
    
        $eliminarPedido = $this->pdo->prepare('
            DELETE FROM pedido WHERE ID_Pedido = :ID_Pedido
        ');
        $eliminarPedido->execute(['ID_Pedido' => $ID_Pedido]);
    
        return true;
    }
    

    public function actualizarEstadoEsperandoPago($ID_Pedido){
        $actualizarEstado = $this -> pdo -> prepare('UPDATE pedido SET estado = "En espera de pago" WHERE ID_Pedido = :ID_Pedido');
        $actualizarEstado->execute(['ID_Pedido' => $ID_Pedido]);
        return true;
    }

    public function actualizarPago($ID_Pedido){
        $stmt = $this->pdo->prepare('UPDATE pedido SET estado = "Procesando Pago" WHERE ID_Pedido = :ID_Pedido');
        $stmt->execute(['ID_Pedido' => $ID_Pedido]);

        return true;
    }

    public function obtenerOrdenes(){

        $ordenes = $this->pdo->prepare('
        SELECT p.ID_Pedido, o.ID_Orden, p.estado, c.email
        FROM pedido as p
        INNER JOIN ordencompra as o
        ON O.ID_Pedido = P.ID_Pedido
        INNER JOIN clientes as c
        ON c.ID = p.ID_Usuario
        WHERE p.estado = "Procesando pago"');
        $ordenes->execute();

        return $ordenes;
    }

    public function obtenerOrdenesCompletadas(){

        $ordenes = $this->pdo->prepare('
        SELECT p.ID_Pedido, o.ID_Orden, p.estado, c.email
        FROM pedido as p
        INNER JOIN ordencompra as o
        ON O.ID_Pedido = P.ID_Pedido
        INNER JOIN clientes as c
        ON c.ID = p.ID_Usuario
        WHERE p.estado = "Completado"');
        $ordenes->execute();

        return $ordenes;
    }

    public function actualizarEstadoAdmin($estado, $ID_Pedido){
        
        $stmt= $this->pdo->prepare('UPDATE pedido SET estado = :estado WHERE ID_Pedido = :ID_Pedido');
        $stmt->execute(['estado'=> $estado, 'ID_Pedido' =>$ID_Pedido]);

        return true;

    }

    public function descargarFactura($ID_Pedido){
        require 'fpdf186/fpdf.php';

        $stmt = $this->pdo->prepare('SELECT p.ID_Pedido, o.*
        FROM pedido AS p
        INNER JOIN ordencompra AS o
        ON o.ID_Pedido = p.ID_Pedido
        WHERE p.ID_Pedido = :ID_Pedido');
        $stmt->execute(['ID_Pedido' => $ID_Pedido]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            die('Pedido no encontrado');
        }

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'MicolVio', 0, 0, 'L');
        $pdf->Cell(0, 10, 'RUT: 041234560011', 0, 1, 'R');
        $pdf->Cell(0, 10, 'Telefono: 099435673', 0, 0, 'L');
        $pdf->Cell(0, 10, 'Contado', 0, 1, 'R');
        $pdf->Cell(0, 10, 'Email: micolvio@gmail.com', 0, 0, 'L');
        $pdf->Cell(0, 10, 'Serie: A Nro: 00'. $pedido['ID_Pedido'], 0, 1, 'R');
        $pdf->Cell(0, 10, 'Fecha: ' . date("Y-m-d"), 0, 1, 'R');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(0, 10, 'MicolVio | E-Ticket', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Cliente: ' . $pedido['nombre']. " ". $pedido['apellido'], 0, 1);
        $pdf->Cell(0, 10, 'C.I: ' . $pedido['cedula'], 0, 1);
        $pdf->Cell(0, 10, 'Direccion: ' . $pedido['departamento'] . ' | ' . $pedido['ciudad'] . " | " . $pedido['dir_envio'], 0, 1);

        $pdf->Ln(10);

        $pdf->Cell(40, 10, 'Producto', 1);
        $pdf->Cell(40, 10, 'Cantidad', 1);
        $pdf->Cell(40, 10, 'Precio Unitario', 1);
        $pdf->Cell(40, 10, 'Total Producto', 1);
        $pdf->Ln();

        $stmtItems = $this->pdo->prepare('SELECT u.*, pr.nombre 
        FROM pedido AS p
        INNER JOIN unioncarritoproducto as u
        ON u.ID_Carrito = p.ID_Carrito
        INNER JOIN producto as pr
        ON pr.ID_Producto = u.ID_Productos
        WHERE p.ID_Pedido = :ID_Pedido');
        $stmtItems->execute(['ID_Pedido' => $ID_Pedido]);
        $productos = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        $totalPedido = 0;
        foreach ($productos as $producto) {
            $totalProducto = $producto['cantidad'] * $producto['precioUnitario'];
            $totalPedido += $totalProducto;
            
            $pdf->Cell(40, 10, $producto['nombre'], 1);
            $pdf->Cell(40, 10, $producto['cantidad'], 1);
            $pdf->Cell(40, 10, '$' . number_format($producto['precioUnitario'], 2), 1);
            $pdf->Cell(40, 10, '$' . number_format($totalProducto, 2), 1);
            $pdf->Ln();
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Subtotal: $' . number_format($totalPedido, 2), 0, 1, 'R');
        $iva = $totalPedido * 0.22; 
        $pdf->Cell(0, 10, 'IVA: $' . number_format($iva, 2), 0, 1, 'R');
        $pdf->Cell(0, 10, 'Total: $' . number_format($totalPedido+$iva, 2), 0, 1, 'R');

        return $pdf->Output('D', 'Factura_Pedido_' . $ID_Pedido . '.pdf');;
    }

}