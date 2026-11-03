<?php
require_once 'functions.php';
session_start();
$action = $_GET['action'];
$name = $_GET['name'];
$dni = $_GET['dni'];
$last_name = $_GET['last_name'];
$age = $_GET['age'];
$password = $_GET['password'];


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
            echo "Usuario registrado correctamente.";
        } else {
            echo "Fallo al registrar el usuario.";
        }
        break;
    
    case 'login':
        if (login($name, $password)) {
            echo "Usuario logeado correctamente.";
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
        break;

    case 'logout':
        logout();
        echo "Deslogeado correctamente.";
        break;

    case 'usertime':
        $timeConnections = totalUserTimeConnection($name);
        if (count($timeConnections) === 0) {
            echo "No se encontraron conexiones para $name.";
            break;
        }
        echo "Tiempo de cada conexion de $name:<br>";
        foreach ($timeConnections as $index => $time) {
            echo "Conexion " . ($index + 1) . ": $time segundos.<br>";
        }
        echo "Tiempo de conexion total $name: " . array_sum($timeConnections) . " segundos.";
        break;

    case 'userdata':
        $userData = showUserData($name);
        if ($userData) {
            echo "Datos del usuario para $name:<br>";
            foreach ($userData as $key => $value) {
                echo "$key: $value<br>";
            }
        } else {
            echo "Usuario no encontrado.";
        }
        break;

    case 'allusers':
        $allUsers = showAllUsers();
        echo "Todos los usuarios:<br>";
        foreach ($allUsers as $user) {
            echo "Nombre: " . $user['name'] . ", Apellido: " . $user['last_name'] . ", DNI: " . $user['dni'] . ", Edad: " . $user['age'] . ", Contraseña: " . $user['password'] . "<br>";
        }
        break;

    case 'allconnections':
        $allConnections = showAllConnections();
        echo "Todas las conexiones:<br>";
        foreach ($allConnections as $connection) {
            echo "Nombre: " . $connection['name'] . ", ID de Sesión: " . $connection['session_id'] . ", Inicio de Sesión: " . $connection['login'] . ", Fin de Sesión: " . $connection['logout'] . "<br>";
        }
        break;

    case 'connectionexpired':
        if (connectionsExpired($name)) {
            if ($name === '') {
                echo "Nombre de usuario no proporcionado.";
                break;
            }
            echo "La conexión para $name ha expirado.";
        } else {
            echo "La conexión para $name aún está activa.";
        }
        break;

    default:
        echo "Acción inválida.";
        break;
}

?>