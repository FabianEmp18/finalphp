<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require_once 'modelo/Database.php';
require_once 'controlador/Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($db);

if (isset($_GET['delete_id'])) {
    $items->id = $_GET['delete_id'];
    if ($items->delete()) {
        $_SESSION['message'] = "El pruducto se ha eliminado correctamente.";
        $_SESSION['message_type'] = "success";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = "Error al eliminar el producto.";
        $_SESSION['message_type'] = "error";
        header('Location: index.php');
        exit;
    }
}

$data = $items->read();

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>Gestión de Productos</title>';
echo '    <link rel="stylesheet" href="css/styles.css">';
echo '</head>';
echo '<body>';

if (isset($_SESSION['message'])) {
    echo '<div class="modal-overlay">';
    echo '    <div class="modal-content ' . $_SESSION['message_type'] . '">';
    echo '        <span class="close-btn">&times;</span>';
    echo '        <p>' . $_SESSION['message'] . '</p>';
    echo '    </div>';
    echo '</div>';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

echo '<div class="container">';
echo '    <h1>Gestión de Productos</h1>';

echo '    <div class="header-buttons">';
echo '        <a href="alta.php" class="btn btn-primary">Crear Nuevo Producto</a>';
echo '        <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar Sesión</a>';
echo '    </div>';

echo '    <table>';
echo '        <tr>';
echo '            <th>ID</th>';
echo '            <th>Nombre</th>';
echo '            <th>Descripción</th>';
echo '            <th>Precio</th>';
echo '            <th>Acciones</th>';
echo '        </tr>';

foreach ($data as $item) {
    echo '<tr>';
    echo '    <td>' . $item['id'] . '</td>';
    echo '    <td>' . $item['name'] . '</td>';
    echo '    <td>' . $item['description'] . '</td>';
    echo '    <td>' . $item['price'] . '</td>';
    echo '    <td class="table-actions">';
    echo '        <a href="modificar.php?id=' . $item['id'] . '" class="btn btn-warning">Editar</a>';
    echo '        <a href="index.php?delete_id=' . $item['id'] . '" class="btn btn-danger">Eliminar</a>';
    echo '    </td>';
    echo '</tr>';
}

echo '    </table>';
echo '</div>';

echo '<script>';
echo '    document.addEventListener("DOMContentLoaded", () => {';
echo '        const modalOverlay = document.querySelector(".modal-overlay");';
echo '        const closeBtn = document.querySelector(".close-btn");';
echo '        if (modalOverlay) {';
echo '            setTimeout(() => {';
echo '                modalOverlay.style.display = "none";';
echo '            }, 3000);';
echo '            closeBtn.addEventListener("click", () => {';
echo '                modalOverlay.style.display = "none";';
echo '            });';
echo '        }';
echo '    });';
echo '</script>';

echo '</body>';
echo '</html>';
?>
