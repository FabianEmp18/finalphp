<?php
session_start();
require_once 'modelo/Database.php';
require_once 'controlador/Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($db);

if (isset($_GET['id'])) {
    $items->id = $_GET['id'];
    $item = $items->readOne();

    if (!$item) {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}

if ($_POST) {
    $items->id = $_POST['id'];
    $items->name = $_POST['name'];
    $items->description = $_POST['description'];
    $items->price = $_POST['price'];

    if ($items->update()) {
        $_SESSION['message'] = "Producto modificado correctamente.";
        $_SESSION['message_type'] = "success";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = "Error al actualizar el producto.";
        $_SESSION['message_type'] = "error";
    }
}

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>Modificar Producto</title>';
echo '    <link rel="stylesheet" href="css/styles.css">';
echo '</head>';
echo '<body>';

echo '    <div class="container">';
echo '        <h1>Modificar Producto</h1>';
echo '        <form method="post" class="form-wrapper">';
echo '            <input type="hidden" name="id" value="' . htmlspecialchars($item['id']) . '">';
            
echo '            <label for="name">Nombre:</label>';
echo '            <input type="text" name="name" value="' . htmlspecialchars($item['name']) . '" required>';

echo '            <label for="description">Descripción:</label>';
echo '            <input type="text" name="description" value="' . htmlspecialchars($item['description']) . '" required>';

echo '            <label for="price">Precio:</label>';
echo '            <input type="number" name="price" value="' . htmlspecialchars($item['price']) . '" required>';

echo '            <div class="actions">';
echo '                <button type="submit" class="btn btn-primary">Actualizar</button>';
echo '                <a href="index.php" class="btn btn-secondary">Volver</a>';
echo '            </div>';
echo '        </form>';
echo '    </div>';

echo '</body>';
echo '</html>';
?>
