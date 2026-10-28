<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
</head>
<body>
    <h1>Bienvenido, <?= escape($_SESSION['username']) ?></h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
