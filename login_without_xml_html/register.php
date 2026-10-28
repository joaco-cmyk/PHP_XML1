<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$message = '';
$registered = false;
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if (!preg_match('/^[A-Za-z0-9_.-]{3,32}$/', $username)) {
        $message = 'El usuario debe tener entre 3 y 32 caracteres: letras, números, punto, guion o guion bajo.';
    } elseif (strlen($password) < 8) {
        $message = 'La contraseña debe tener al menos 8 caracteres.';
    } else {
        $statement = database()->prepare(
            'INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)'
        );

        try {
            $statement->execute([
                ':username' => $username,
                ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            $message = 'Cuenta creada. Ya puedes iniciar sesión.';
            $registered = true;
        } catch (PDOException $exception) {
            if ($exception->getCode() !== '23000') {
                throw $exception;
            }

            $message = 'Ese nombre de usuario ya está registrado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
</head>
<body>
    <h1>Crear cuenta</h1>
    <?php if ($message !== ''): ?>
        <p><?= escape($message) ?></p>
    <?php endif; ?>
    <?php if (!$registered): ?>
        <form action="register.php" method="post">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" minlength="3" maxlength="32"
                   pattern="[A-Za-z0-9_.-]+" value="<?= escape($username) ?>" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" minlength="8" required>
            <br>
            <button type="submit">Crear cuenta</button>
        </form>
    <?php endif; ?>
    <p><a href="index.php">Volver al inicio de sesión</a></p>
</body>
</html>
