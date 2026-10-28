<?php
$message = '';
$registered = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!preg_match('/^[A-Za-z0-9_.-]{3,32}$/', $username)) {
        $message = 'El usuario debe tener entre 3 y 32 caracteres: letras, números, punto, guion o guion bajo.';
    } elseif (strlen($password) < 8) {
        $message = 'La contraseña debe tener al menos 8 caracteres.';
    } else {
        $xmlPath = __DIR__ . '/login_prueba.xml';
        $file = @fopen($xmlPath, 'c+');

        if ($file === false || !flock($file, LOCK_EX)) {
            $message = 'No se pudo acceder al archivo de usuarios.';
        } else {
            rewind($file);
            $contents = stream_get_contents($file);
            $xml = trim($contents) === ''
                ? new SimpleXMLElement('<login/>')
                : @simplexml_load_string($contents);

            if ($xml === false) {
                $message = 'El archivo de usuarios contiene XML no válido.';
            } else {
                $usernameExists = false;
                foreach ($xml->username as $user) {
                    if (strcasecmp((string) $user->name, $username) === 0) {
                        $usernameExists = true;
                        break;
                    }
                }

                if ($usernameExists) {
                    $message = 'Ese nombre de usuario ya está registrado.';
                } else {
                    $user = $xml->addChild('username');
                    $user->addChild('name', $username);
                    $user->addChild('password', password_hash($password, PASSWORD_DEFAULT));
                    $updatedXml = $xml->asXML();

                    if ($updatedXml !== false) {
                        rewind($file);
                        if (ftruncate($file, 0) && fwrite($file, $updatedXml) === strlen($updatedXml) && fflush($file)) {
                            $message = 'Cuenta creada. Ya puedes iniciar sesión.';
                            $registered = true;
                        } else {
                            $message = 'No se pudo guardar la nueva cuenta.';
                        }
                    } else {
                        $message = 'No se pudo generar el XML de usuarios.';
                    }
                }
            }

            flock($file, LOCK_UN);
        }

        if (is_resource($file)) {
            fclose($file);
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
        <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <?php if (!$registered): ?>
        <form action="registro.php" method="post">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" minlength="3" maxlength="32" pattern="[A-Za-z0-9_.-]+" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" minlength="8" required>
            <br>
            <input type="submit" value="Crear cuenta">
        </form>
    <?php endif; ?>
    <p><a href="index.php">Volver al login</a></p>
</body>
</html>