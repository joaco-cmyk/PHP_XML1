<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    $xml = @simplexml_load_file(__DIR__ . '/login_prueba.xml');

    if ($xml !== false) {
        foreach ($xml->username as $user) {
            if (strcasecmp((string) $user->name, $username) !== 0) {
                continue;
            }

            $storedPassword = (string) $user->password;
            $passwordInfo = password_get_info($storedPassword);
            $passwordMatches = $passwordInfo['algo'] !== null
                ? password_verify($password, $storedPassword)
                : hash_equals($storedPassword, $password);

            if ($passwordMatches) {
                session_regenerate_id(true);
                $_SESSION['username'] = (string) $user->name;
                header('Location: panel.php');
                exit();
            }
        }
    }

    header('Location: index.php?error=1');
    exit();
}

?>