<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (isset($_SESSION['user_id'])) {
    recordConnection(database(), (int) $_SESSION['user_id'], 'logout');
}

$_SESSION = [];
session_destroy();

header('Location: index.php');
exit;
