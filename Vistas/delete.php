<?php
session_start();
require_once 'modelo/Database.php';
require_once 'controlador/Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($db);

// Verificar si se pasa un ID para eliminar
if (isset($_GET['id'])) {
    $items->id = $_GET['id'];
    
    if ($items->delete()) {
        // Si la eliminación fue exitosa, almacenar mensaje en la sesión
        $_SESSION['message'] = "Producto eliminado correctamente.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al eliminar el Producto.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: index.php');
    exit;
} else {
    echo "ID no proporcionado.";
}
