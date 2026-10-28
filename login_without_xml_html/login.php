<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
$password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

$statement = database()->prepare(
    'SELECT id, username, password_hash FROM users WHERE username = :username'
);
$statement->execute([':username' => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user === false || !password_verify($password, $user['password_hash'])) {
    header('Location: index.php?error=1');
    exit;
}

recordConnection(database(), (int) $user['id'], 'login');
session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];

header('Location: panel.php');
exit;
