<?php

function saveXmlFile($xml, $file) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($file);
}

function userExists($name){
    $users = simplexml_load_file('users.xml');
    foreach ($users->user as $u) {
        if ($u ->name === $name) {
            return true;
        }
    }
    return false;
}

function register($user_info) {
    $name = $user_info['name'];
    $password = $user_info['password'];
    $last_name = $user_info['last_name'];
    $dni = $user_info['dni'];
    $age = $user_info['age'];
    if (userExists($name)) return false;
    $users =simplexml_load_file('users.xml');
    $newUser = $users->addChild('user');
    if ($name === null) {
        echo "Error: No se ha indicado nombre\n";
        return false;
    } else {
        $newUser->addChild('name', $name);
    }
    if ($password === null) {
        echo "Error: No se ha indicado contraseña\n";
        return false;
    } else {
        $newUser->addChild('password', $password);
    }
    if ($last_name === null) {
        echo "Error: No se ha indicado apellido\n";
        return false;
    } else {
        $newUser->addChild('last_name', $last_name);
    }
    if ($dni === null) {
        echo "Error: No se ha indicado DNI\n";
        return false;
    } else {
        $newUser->addChild('dni', $dni);
    }
    if ($age === null) {
        echo "Error: No se ha indicado edad\n";
        return false;
    } else {
        $newUser->addChild('age', $age);
    }
    saveXmlFile($users, 'users.xml');
    return true;
}

function login($name, $password) {
    $users = simplexml_load_file('users.xml');
    foreach ($users->user as $u) {
        if ((string)$u->name === $name && (string)$u->password === $password) {   
            session_regenerate_id(true);
            $_SESSION['name'] = $name;
            $connection = simplexml_load_file('connections.xml');
            $newConnection = $connection->addChild('connection');
            $newConnection->addChild('name', $name);
            $newConnection->addChild('session_id', session_id());
            $newConnection->addChild('login', date('Y-m-d H:i:s'));
            $newConnection->addChild('logout', '');
            saveXmlFile($connection, 'connections.xml');
            return true;
        }
    }
    return false;
}

function logout() {
    if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
        $connection = simplexml_load_file('connections.xml');
        foreach ($connection->connection as $c) {
            if (
                (string) $c->name === $name &&
                (string) $c->session_id === session_id() &&
                (string) $c->logout === ''
            ) {
                $c->logout = date('Y-m-d H:i:s');
                break;
            }
        }
        saveXmlFile($connection, 'connections.xml');
    }
    session_unset();
    session_destroy();
}

function totalUserTimeConnection($name) {
    $connections = simplexml_load_file('connections.xml');
    $timeConnections = [];
    foreach ($connections->connection as $c) {
        if ((string)$c->name === $name) {
            $loginTime = strtotime((string)$c->login);
            $logout = (string)$c->logout;
            $endTime = $logout === '' ? time() : strtotime($logout);
            if ($loginTime !== false && $endTime !== false && $endTime >= $loginTime) {
                $timeConnections[] = $endTime - $loginTime;
            }
        }
    }
    return $timeConnections;
}

function showUserData($name) {
    $users = simplexml_load_file('users.xml');
    foreach ($users->user as $u) {
        if ((string)$u->name === $name) {
            return [
                'name' => (string)$u->name,
                'last_name' => (string)$u->last_name,
                'dni' => (string)$u->dni,
                'age' => (string)$u->age
            ];
        }
    }
    return null;
}

function showAllUsers() {
    $users = simplexml_load_file('users.xml');
    $userList = [];
    foreach ($users->user as $u) {
        $userList[] = [
            'name' => (string)$u->name,
            'last_name' => (string)$u->last_name,
            'dni' => (string)$u->dni,
            'age' => (string)$u->age,
            'password' => (string)$u->password
        ];
    }
    return $userList;
}

function showAllConnections() {
    $connections = simplexml_load_file('connections.xml');
    $connectionList = [];
    foreach ($connections->connection as $c) {
        $connectionList[] = [
            'name' => (string)$c->name,
            'session_id' => (string)$c->session_id,
            'login' => (string)$c->login,
            'logout' => (string)$c->logout
        ];
    }
    return $connectionList;
}

function connectionsExpired($name) {
    $connections = simplexml_load_file('connections.xml');
    foreach ($connections->connection as $c) {
        if ((string)$c->name === $name && (string)$c->logout === '') {
            return false; // El usuario esta logeado
        }
    }
    return true; // el usuario no esta logeado
}

?>