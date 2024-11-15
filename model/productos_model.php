<?php
require "config.php";

class Productos {

    private $pdo;
    //PDO (PHP Data Objects) es una extensión de PHP que proporciona una interfaz uniforme para acceder a bases de datos desde PHP
    // Constructor que recibe la conexión PDO como argumento
    public function __construct() {
        $this->pdo = getConnection();
    }

    public function crearCategoria($nombreCategoria){

        if(!self::buscarCategoria($nombreCategoria)){

            $stmt = $this->pdo->prepare('INSERT INTO categoria (Nombre) VALUES (:Nombre)');
            $stmt->execute(['Nombre' => $nombreCategoria]);

            return true;

        } else {
            return false;
        }

    }

    public function obtenerCategorias() {
        $stmt = $this->pdo->prepare('SELECT * FROM categoria');
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }

    public function obtenerCategoria($idCategoria){
        $stmt = $this->pdo->prepare('SELECT * FROM categoria WHERE ID_Categoria = :ID_Categoria');
        $stmt->execute(['ID_Categoria' => $idCategoria]);
        $categorias = $stmt->fetch(PDO::FETCH_ASSOC);
        return $categorias;
    }

    public function actualizarCategoria($catModificada, $idCategoria){

        $stmt = $this->pdo->prepare('UPDATE categoria SET Nombre = :Nombre WHERE categoria.ID_Categoria = :ID_Categoria');
        if(!self::buscarCategoria($catModificada)){
        $stmt->execute(['Nombre' => $catModificada, 'ID_Categoria' => $idCategoria]);            
        return true;
        }
        else{
            echo 'Nombre de categoria duplicado <br>';
            return false;
        }

    }

    public function eliminarCategoria($idCategoria){
        $stmt = $this->pdo->prepare('DELETE FROM categoria WHERE categoria.ID_Categoria = :ID_Categoria');
        $stmt->execute(['ID_Categoria' => $idCategoria]);
        return true;
    }

    public function obtenerProductos() {
        $stmt = $this->pdo->prepare('SELECT p.*, c.Nombre as nombreCat, a.nombre as nombreAdmin, GROUP_CONCAT(DISTINCT s.Talle ORDER BY s.Talle SEPARATOR ", ") as Talle, s.cantidad 
        FROM producto AS p 
        INNER JOIN categoria AS c 
        ON c.ID_Categoria = p.ID_Categoria 
        INNER JOIN administrador AS a 
        ON a.ID = p.ID_Administrador 
        INNER JOIN stock AS s 
        ON s.producto_id = p.ID_Producto 
        GROUP BY p.ID_Producto');
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function obtenerProductosEImagen() {
        $stmt = $this->pdo->prepare('SELECT producto.*, MIN(imagenproducto.ruta_imagen) AS ruta_imagen 
        FROM producto 
        LEFT JOIN imagenproducto 
        ON producto.ID_Producto = imagenproducto.producto_id 
        GROUP BY producto.ID_Producto');
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }
    
    public function obtenerProductoUnico($ID_Producto){
        $stmt = $this->pdo->prepare('SELECT p.*, c.Nombre as nombreCat, a.nombre as nombreAdmin, GROUP_CONCAT(DISTINCT s.Talle ORDER BY s.Talle SEPARATOR ",") as Talles, GROUP_CONCAT(DISTINCT s.cantidad ORDER BY s.cantidad SEPARATOR ",") AS cantidad 
        FROM producto AS p 
        INNER JOIN categoria AS c 
        ON c.ID_Categoria = p.ID_Categoria 
        INNER JOIN administrador AS a 
        ON a.ID = p.ID_Administrador 
        INNER JOIN stock AS s 
        ON s.producto_id = p.ID_Producto 
        WHERE p.ID_Producto = :ID_Producto 
        GROUP BY p.ID_Producto');
        $stmt->execute(['ID_Producto' => $ID_Producto ]);
        $productos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $productos;
    }

    public function obtenerImagenesProductoAModificar($ID_Producto){
        $stmt = $this->pdo->prepare('SELECT img.* 
        FROM producto as p 
        INNER JOIN imagenproducto as img 
        ON img.producto_id = p.ID_Producto 
        WHERE p.ID_Producto = :ID_Producto');
        $stmt-> execute(['ID_Producto' => $ID_Producto ]);
        $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $imagenes;
    }

    public function obtenerImagenProductoUnico($ID_Producto){
    
        $stmt = $this->pdo->prepare('SELECT imagenproducto.* 
        FROM producto 
        LEFT JOIN imagenproducto 
        ON producto.ID_Producto = imagenproducto.producto_id 
        WHERE ID_Producto = :ID_Producto 
        ORDER BY `imagenproducto`.`ruta_imagen` 
        ASC LIMIT 18446744073709551615 OFFSET 1'); // obtener todas las imagens menos la primera

        $stmt-> execute(['ID_Producto' => $ID_Producto ]);
        $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $imagenes;

     }

     public function obtenerPrimerImagenUnica($ID_Producto){
        $stmt = $this->pdo->prepare('SELECT MIN(imagenproducto.ruta_imagen) AS ruta_imagen 
        FROM producto 
        LEFT JOIN imagenproducto 
        ON producto.ID_Producto = imagenproducto.producto_id 
        WHERE producto.ID_Producto = :ID_Producto');
        $stmt-> execute(['ID_Producto' => $ID_Producto ]);
        $imagenUnica = $stmt->fetch(PDO::FETCH_ASSOC);
        return $imagenUnica;
     }


    
    
     private function buscarCategoria ($nombreCategoria) {

        $stmt = $this->pdo->prepare('SELECT * FROM categoria WHERE Nombre = :Nombre');
        $stmt->execute(['Nombre' => $nombreCategoria]);
        $Categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($Categoria) {

            if ($nombreCategoria === $Categoria['Nombre']) {
                
                return true;

            } else{

                return false;

            }

        }   else {

            return false;

        }

    }

    public function agregarProductoConImagenes($nombreProducto, $nombreCategoria, $colores, $talles, $precio, $descripcionProducto, $imagenes, $idAdmin, $tipoStock, $stockPorTalle) {
        $estado = 'Stock controlado';
        // Iniciar una transacción para asegurar que ambos inserts se realicen correctamente
        $this->pdo->beginTransaction();

        try {
            // Convertir los arrays de colores y talles en strings separados por comas
            $coloresString = implode(',', $colores);
            $tallesString = implode(',', $talles);
    
            $stmt = $this->pdo->prepare('SELECT ID_Categoria FROM categoria WHERE Nombre = :Nombre');
            $stmt->execute(['Nombre' => $nombreCategoria]);
            $Categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCategoria = $Categoria['ID_Categoria'];

            if($tipoStock === 'produccion'){
                $estado = 'En produccion';
            }

            $stmt = $this->pdo->prepare('INSERT INTO producto (Nombre, ID_Categoria, Color, tipoStock, estado, Precio, Descripcion, ID_Administrador) VALUES (:Nombre, :ID_Categoria, :Color, :tipoStock, :estado, :Precio, :Descripcion, :ID_Administrador)');
            $stmt->execute([
                'Nombre' => $nombreProducto,
                'ID_Categoria' => $idCategoria,
                'Color' => $coloresString,
                'tipoStock' => $tipoStock,
                'estado' => $estado,
                'Precio' => $precio,
                'Descripcion' => $descripcionProducto,
                'ID_Administrador' => $idAdmin
            ]);
    
            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() === 0) {
                throw new Exception('Error al insertar el producto en la base de datos.');
                return false;
                exit();
            }
    
            // Obtener el ID del producto recién insertado
            $productoId = $this->pdo->lastInsertId();
    
            // Insertar stock si es tipo stock físico
            if ($tipoStock === 'fisico') {
                foreach ($stockPorTalle as $talle => $cantidad) {
                    $stmtStock = $this->pdo->prepare('INSERT INTO Stock (producto_id, Talle, Cantidad) VALUES (:producto_id, :Talle, :Cantidad)');
                    $stmtStock->execute([
                        'producto_id' => $productoId,
                        'Talle' => $talle,
                        'Cantidad' => $cantidad
                    ]);
                }
            }

            if ($tipoStock === 'produccion') {
                foreach ($stockPorTalle as $talle) {
                    $stmtStock = $this->pdo->prepare('INSERT INTO Stock (producto_id, Talle) VALUES (:producto_id, :Talle)');
                    $stmtStock->execute([
                        'producto_id' => $productoId,
                        'Talle' => $talle
                    ]);
                }
            }


    
            // Subir imágenes del producto
            $carpetaDestino = 'assets/imagenes/';
            if (!file_exists($carpetaDestino)) {
                if (!mkdir($carpetaDestino, 0777, true)) {
                    throw new Exception('Error al crear la carpeta de destino.');
                    return false;
                    exit();
                }
            }
    
            foreach ($imagenes['tmp_name'] as $key => $tmpName) {
                if ($imagenes['error'][$key] == 0 && is_uploaded_file($tmpName)) {
                    $nombreArchivo = $imagenes['name'][$key];
                    $rutaTemporal = $tmpName;
                    $rutaDestino = $carpetaDestino . basename($nombreArchivo);
    
                    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                        $stmt = $this->pdo->prepare('INSERT INTO imagenproducto (producto_id, ruta_imagen) VALUES (:producto_id, :ruta_imagen)');
                        $stmt->execute(['producto_id' => $productoId, 'ruta_imagen' => $rutaDestino]);
    
                        if ($stmt->rowCount() === 0) {
                            throw new Exception('Error al insertar la ruta de la imagen en la base de datos.');
                            return false;
                            exit();
                        }
                    } else {
                        throw new Exception('Error al mover la imagen al destino.');
                        return false;
                        exit();
                    }
                } else {
                    throw new Exception('Error en el archivo subido: ' . $imagenes['error'][$key]);
                    return false;
                    exit();
                }
            }
    
            // Confirmar la transacción si todo ha ido bien
            $this->pdo->commit();
            return true;
    
        } catch (Exception $e) {
            // Si hay algún error, deshacer los cambios
            $this->pdo->rollBack();
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    

    public function agregarImagenProducto($ID_Producto, $imagen){

        
        $carpetaDestino = 'assets/imagenes/';
    
        // Crear carpeta si no existe
        if (!file_exists($carpetaDestino)) {
            if (!mkdir($carpetaDestino, 0777, true)) {
                echo 'Error al crear la carpeta destino';
                return false;
            }
        }
    
        // Verificar que el archivo se haya subido correctamente
        if ($imagen['error'] === 0 && is_uploaded_file($imagen['tmp_name'])) {
            $nombreArchivo = basename($imagen['name']);  // Añadir un prefijo único al nombre del archivo
            $rutaTemporal = $imagen['tmp_name'];
            $rutaDestino = $carpetaDestino . $nombreArchivo;
    
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $stmt = $this->pdo->prepare('INSERT INTO imagenproducto (producto_id, ruta_imagen) VALUES (:producto_id, :ruta_imagen)');
                $stmt->execute(['producto_id' => $ID_Producto, 'ruta_imagen' => $rutaDestino]);
                return true;
            } else {
                echo 'Error al mover el archivo subido.';
                return false;
            }
        } else {
            echo 'Error en el archivo subido.';
            return false;
        }
    }
    

    public function eliminarProducto($ID_Producto){

        if(empty($ID_Producto)){
            echo 'No se pudo obtener la id del producto';
            return false;
        }

        $imagenes = $this->eliminarImagenes($ID_Producto);

        foreach ($imagenes as $imagen) {
            $rutaImagen = $imagen['ruta_imagen'];  // Asegúrate de que el campo de la ruta se llame 'rutaImagen'
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); 
            }
        }

        $stmt = $this->pdo->prepare('DELETE FROM imagenproducto WHERE `imagenproducto`.`producto_id` = :producto_id');
        $stmt -> execute(['producto_id' => $ID_Producto]);

        $stmt = $this->pdo->prepare('DELETE FROM producto WHERE `producto`.`ID_Producto` = :ID_Producto');
        $stmt -> execute(['ID_Producto' => $ID_Producto]);

        echo $ID_Producto;
        return true;
    }

    public function obtenerIDProducto($ID_Producto){
        $stmt = $this->pdo->prepare('SELECT ID_Producto FROM producto WHERE ID_Producto = :producto_id');
        $stmt->execute(['producto_id' => $ID_Producto]);
        return $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function eliminarImagenes($ID_Producto){
        
        if(empty($ID_Producto)){
            echo 'No se pudo obtener la id del producto';
            return false;
        }

        $stmt = $this->pdo->prepare('SELECT * FROM imagenproducto WHERE producto_id = :producto_id');
        $stmt->execute(['producto_id' => $ID_Producto]);
        $ImagenProducto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ImagenProducto;
    }
    
    public function eliminarImagenUnica($ID_Imagen, $ID_Producto){
        
        $img = $this->pdo->prepare('SELECT ruta_imagen FROM imagenproducto WHERE id_imagen = :id_imagen');
        $img -> execute(['id_imagen' => $ID_Imagen]);
        $img = $img->fetch(PDO::FETCH_ASSOC);

        $rutaImagen = $img['ruta_imagen'];
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); 
            }
        
        $stmt = $this->pdo->prepare('DELETE FROM imagenproducto WHERE `imagenproducto`.`id_imagen` = :id_imagen');
        $stmt->execute(['id_imagen' => $ID_Imagen]);

        return true;
    }

    public function actualizarProducto($ID_Producto, $opcionModificada, $modificacion){

        if(empty($ID_Producto) || empty($opcionModificada) || empty($modificacion)){
            echo 'uno de los campos esta vacio';
            return false;
        }

        $consulta = "UPDATE producto SET $opcionModificada = :modificacion WHERE ID_Producto = :ID_Producto"; //preparamos la consulta desde antes porque sino de problemas 

        $stmt = $this->pdo->prepare($consulta);

        $stmt->execute(['ID_Producto' => $ID_Producto, 'modificacion' => $modificacion]);

        return true;

    }

    public function modificarCategoria($catModificada, $ID_Producto){

        $categoria = $this->pdo->prepare('SELECT ID_Categoria FROM categoria WHERE Nombre = :Nombre');
        $categoria -> execute(['Nombre' => $catModificada]);
        $categoria = $categoria->fetch(PDO::FETCH_ASSOC);
    
        if ($categoria) { 
            
            $modificacion = $this->pdo->prepare('UPDATE producto SET ID_Categoria = :ID_Categoria WHERE ID_Producto = :ID_Producto');
            $modificacion->execute(['ID_Categoria' => $categoria['ID_Categoria'], 'ID_Producto' => $ID_Producto]);
    
            return true;
        } else {
            
            echo "Categoría no encontrada.";
            return false;
        }
    }

    public function quitarProduccion($ID_Producto){

        $stmt = $this->pdo->prepare('UPDATE producto SET estado = :estado WHERE producto.ID_Producto = :ID_Producto');
        $stmt-> execute(['ID_Producto' => $ID_Producto, 'estado' => "Fuera de produccion"]);
        $estadoAct = $stmt->fetch(PDO::FETCH_ASSOC);
        return $estadoAct;

    }

    public function agregarAProduccion($ID_Producto){
        $stmt = $this->pdo->prepare('UPDATE producto SET estado = :estado WHERE producto.ID_Producto = :ID_Producto');
        $stmt-> execute(['ID_Producto' => $ID_Producto, 'estado' => "En produccion"]);
        $estadoAct = $stmt->fetch(PDO::FETCH_ASSOC);
        return $estadoAct;
    }

    public function generarRanking(){

    $stmt = $this->pdo->prepare('
        INSERT INTO ranking (ID_Producto, veces_vendido)
        SELECT u.ID_Productos, SUM(u.cantidad) as cantidadVendida
        FROM unioncarritoproducto as u
        INNER JOIN pedido as p ON u.ID_Carrito = p.ID_Carrito
        WHERE p.estado = "Completado" AND p.procesado = 0
        GROUP BY u.ID_Productos
        ON DUPLICATE KEY UPDATE veces_vendido = veces_vendido + VALUES(veces_vendido);
    ');
    $stmt->execute();
    
    $marcarProcesado = $this->pdo->prepare('
        UPDATE pedido SET procesado = 1
        WHERE estado = "Completado" AND procesado = 0
    ');
    $marcarProcesado->execute();

    return true;

    }

    public function obtenerProductosRanking(){
        $consultaRanking = $this->pdo->prepare("
            SELECT p.Nombre, MIN(i.ruta_imagen) AS ruta_imagen , r.veces_vendido, p.ID_Producto
            FROM ranking r
            INNER JOIN producto p 
            ON r.ID_Producto = p.ID_Producto
            INNER JOIN imagenproducto as i 
            ON i.producto_id = r.ID_Producto
            GROUP BY r.ID_Producto
            ORDER BY r.veces_vendido DESC
            LIMIT 5
        ");
        $consultaRanking->execute();
        $productosMasVendidos = $consultaRanking->fetchAll(PDO::FETCH_ASSOC);
        return $productosMasVendidos;
    }
}

?>