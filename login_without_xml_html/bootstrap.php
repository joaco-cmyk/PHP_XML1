<?php
declare(strict_types=1);

session_start();

function database(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $databasePath = getenv('LOGIN_DB_PATH')
        ?: sys_get_temp_dir() . '/php_xml1_login_' . hash('sha256', __DIR__) . '.sqlite';
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL COLLATE NOCASE UNIQUE,
            password_hash TEXT NOT NULL
        )'
    );
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS connections (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL REFERENCES users(id),
            action TEXT NOT NULL CHECK (action IN (\'login\', \'logout\')),
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )'
    );

    return $pdo;
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function recordConnection(PDO $pdo, int $userId, string $action): void
{
    $statement = $pdo->prepare(
        'INSERT INTO connections (user_id, action) VALUES (:user_id, :action)'
    );
    $statement->execute([
        ':user_id' => $userId,
        ':action' => $action,
    ]);
}
