<?php
session_start();

$correct_username = 'admin';
$correct_password = 'prueba';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error_message = "Usuario o contraseña incorrectos";
    }
}

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>Login</title>';
echo '    <link rel="stylesheet" href="css/styles.css">';
echo '</head>';
echo '<body>';

echo '    <div class="login-container">';
echo '        <h1>Iniciar Sesión</h1>';

if (isset($error_message)) {
    echo '        <p class="error">' . $error_message . '</p>';
}

echo '        <form action="login.php" method="POST">';
echo '            <input type="text" name="username" placeholder="Usuario" required>';
echo '            <input type="password" name="password" placeholder="Contraseña" required>';
echo '            <button type="submit">Ingresar</button>';
echo '        </form>';
echo '    </div>';

echo '</body>';
echo '</html>';
?>
