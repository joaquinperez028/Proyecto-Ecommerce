<link rel="shortcut icon" href="assets/imagenes/logo.png" type="image/x-icon">
<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=user&action=logout');
    exit();
    }

    if ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'superAdmin') {
        header('Location: index.php?controller=productos&action=verProductos');
        exit();
    }
    
?>