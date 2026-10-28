<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: panel.php');
    exit;
}

$error = isset($_GET['error']) && $_GET['error'] === '1';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <?php if ($error): ?>
        <p>Usuario o contraseña incorrectos.</p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p><a href="register.php">Crear una cuenta</a></p>
</body>
</html>
