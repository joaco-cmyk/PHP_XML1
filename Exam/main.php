<?php
require_once 'functions.php';
session_start();
$action = $_GET['action'] ?? '';
$name = $_GET['name'] ?? '';
$dni = $_GET['dni'] ?? null;
$last_name = $_GET['last_name'] ?? null;
$age = $_GET['age'] ?? null;
$password = $_GET['password'] ?? null;
$response = [];

switch ($action) {
    case 'register':
        $user_info = array(
            'name' => $name,
            'last_name' => $last_name,
            'dni' => $dni,
            'age' => $age,
            'password' => $password
        );
        if (register($user_info)) {
            $response['message'] = "El usuario $name fue registrado correctamente.";
            $response['user'] = showUserData($name);
        } else {
            $response['message'] = "No se pudo registrar al usuario $name.";
        }
        break;

    case 'login':
        if (login($name, $password ?? '')) {
            $response['message'] = "El usuario $name inició sesión correctamente.";
            $response['user'] = showUserData($name);
            $response['connection'] = showUserConnection($name, session_id());
        } else {
            $response['message'] = "No se pudo iniciar sesión para el usuario $name: nombre o contraseña incorrectos.";
        }
        break;

    case 'logout':
        $loggedOutUser = $_SESSION['name'] ?? null;
        $loggedOutSessionId = session_id();
        logout();
        $response['message'] = $loggedOutUser !== null
            ? "El usuario $loggedOutUser cerró sesión correctamente."
            : 'No hay ningún usuario con sesión iniciada.';
        if ($loggedOutUser !== null) {
            $response['user'] = showUserData($loggedOutUser);
            $response['connection'] = showUserConnection($loggedOutUser, $loggedOutSessionId);
        }
        break;

    case 'usertime':
        $timeConnections = totalUserTimeConnection($name);
        if (count($timeConnections) === 0) {
            $response['message'] = "No se encontraron conexiones para $name.";
            break;
        }
        $response['message'] = "Tiempos de conexión del usuario $name.";
        $response['connections'] = $timeConnections;
        $response['total_time'] = array_sum($timeConnections);
        break;

    case 'userdata':
        $userData = showUserData($name);
        if ($userData) {
            $response['message'] = "Datos del usuario $name.";
            $response['user'] = $userData;
        } else {
            $response['message'] = 'Usuario no encontrado.';
        }
        break;

    case 'allusers':
        $response['message'] = 'Listado de usuarios registrados.';
        $response['users'] = showAllUsers();
        break;

    case 'allconnections':
        $response['message'] = 'Historial de todas las conexiones.';
        $response['connections'] = showAllConnections();
        break;

    case 'connectionexpired':
        if ($name === '') {
            $response['message'] = 'Nombre de usuario no proporcionado.';
            break;
        }
        $expired = connectionsExpired($name);
        $response['message'] = $expired
            ? "El usuario $name no tiene una conexión activa."
            : "El usuario $name tiene una conexión activa.";
        $response['expired'] = $expired;
        break;

    default:
        $response['message'] = 'Acción inválida.';
        break;
}

outputXml($response);
?>
