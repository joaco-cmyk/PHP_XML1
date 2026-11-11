<?php
require_once __DIR__ . '/functions.php';

$users = showAllUsers();
$connectionStatuses = [];
foreach ($users as $user) {
    $connectionStatuses[] = [
        'name' => $user['name'],
        'expired' => connectionsExpired($user['name'])
    ];
}

outputXml([
    'users' => $users,
    'connections' => showAllConnections(),
    'connection_statuses' => $connectionStatuses
]);
?>
