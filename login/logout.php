<?php
session_start();
session_destroy();
$xml = @simplexml_load_file(__DIR__ . '/login_prueba.xml');
if ($xml !== false) {
    $xml->addChild('connection');
    $xml->connection->addChild('user', $_SESSION['username'] ?? 'unknown');
    $xml->connection->addChild('date', date('Y-m-d H:i:s'));
    $xml->connection->addChild('action', 'logout');
    $xml->asXML(__DIR__ . '/login_prueba.xml');
}
header("Location: index.php");
exit();