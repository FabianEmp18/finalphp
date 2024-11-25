<?php
require_once '../modelo/Database.php';
require_once '../controlador/Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($db);

$data = $items->read();

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>Gestión de Items</title>';
echo '    <link rel="stylesheet" href="../css/styles.css">';
echo '</head>';
echo '<body>';
echo '    <div class="container">';
echo '        <h1>Gestión de Items</h1>';
echo '        <a href="../alta.php" class="btn btn-primary">Crear Nuevo Item</a>';
echo '        <a href="../cerrar_sesion.php" class="btn btn-danger">Cerrar Sesión</a>';

echo '        <table>';
echo '            <tr>';
echo '                <th>ID</th>';
echo '                <th>Nombre</th>';
echo '                <th>Descripción</th>';
echo '                <th>Precio</th>';
echo '                <th>Acciones</th>';
echo '            </tr>';

foreach ($data as $item) {
    echo '            <tr>';
    echo '                <td>' . htmlspecialchars($item['id']) . '</td>';
    echo '                <td>' . htmlspecialchars($item['name']) . '</td>';
    echo '                <td>' . htmlspecialchars($item['description']) . '</td>';
    echo '                <td>' . htmlspecialchars($item['price']) . '</td>';
    echo '                <td>';
    echo '                    <form action="../vista/delete.php" method="post" style="display:inline;">';
    echo '                        <input type="hidden" name="id" value="' . htmlspecialchars($item['id']) . '">';
    echo '                        <button type="submit" class="btn btn-danger">Eliminar</button>';
    echo '                    </form>';
    echo '                    <a href="../modificar.php?id=' . htmlspecialchars($item['id']) . '" class="btn btn-warning">Editar</a>';
    echo '                </td>';
    echo '            </tr>';
}

echo '        </table>';
echo '    </div>';
echo '</body>';
echo '</html>';
?>
