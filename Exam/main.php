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
        $response['message'] = register($user_info)
            ? 'Usuario registrado correctamente.'
            : 'Fallo al registrar el usuario.';
        break;

    case 'login':
        $response['message'] = login($name, $password ?? '')
            ? 'Usuario logeado correctamente.'
            : 'Nombre de usuario o contraseña incorrectos.';
        break;

    case 'logout':
        logout();
        $response['message'] = 'Deslogeado correctamente.';
        break;

    case 'usertime':
        $timeConnections = totalUserTimeConnection($name);
        if (count($timeConnections) === 0) {
            $response['message'] = "No se encontraron conexiones para $name.";
            break;
        }
        $response['message'] = "Tiempo de cada conexion de $name.";
        $response['connections'] = $timeConnections;
        $response['total_time'] = array_sum($timeConnections);
        break;

    case 'userdata':
        $userData = showUserData($name);
        if ($userData) {
            $response['message'] = "Datos del usuario para $name.";
            $response['user'] = $userData;
        } else {
            $response['message'] = 'Usuario no encontrado.';
        }
        break;

    case 'allusers':
        $response['message'] = 'Todos los usuarios.';
        $response['users'] = showAllUsers();
        break;

    case 'allconnections':
        $response['message'] = 'Todas las conexiones.';
        $response['connections'] = showAllConnections();
        break;

    case 'connectionexpired':
        if ($name === '') {
            $response['message'] = 'Nombre de usuario no proporcionado.';
            break;
        }
        $expired = connectionsExpired($name);
        $response['message'] = $expired
            ? "La conexión para $name ha expirado."
            : "La conexión para $name aún está activa.";
        $response['expired'] = $expired;
        break;

    default:
        $response['message'] = 'Acción inválida.';
        break;
}

outputXml($response);
?>
