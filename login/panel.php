<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>