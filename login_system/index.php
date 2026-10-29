<?php
require 'functions.php';
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if (isset($_GET['username']) && isset($_GET['password'])) {
    $xml = loadXmlFile(__DIR__ . '/users.xml');

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
                session_start();
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


