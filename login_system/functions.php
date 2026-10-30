<?php
function loadXmlFile($file, $root = null) {
    if (!file_exists($file)) {
        file_put_contents($file, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><$root/>");
    }
    return simplexml_load_file($file);
}

function saveXmlFile($xml, $file) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($file);
}

function userExists($username){
    $users = loadXmlFile('users.xml', 'users');
    foreach ($users->user as $u) {
        if ((string) $u->username === $username) {
            return true;
        }
    }
    return false;
}


function register($username, $password) {
    if (userExists($username)) return false;
    $users = loadXmlFile('users.xml', 'users');
    $newUser = $users->addChild('user');
    $newUser->addChild('username', $username);
    $newUser->addChild('password', $password);
    saveXmlFile($users, 'users.xml');
    return true;
}

function login($username, $password) {
    $users = loadXmlFile('users.xml', 'users');
    foreach ($users->user as $u) {
        if ((string) $u->username === $username && (string) $u->password === $password) {
            $_SESSION['username'] = $username;

            $connection = loadXmlFile('connections.xml', 'connections');
            $newConnection = $connection->addChild('connection');
            $newConnection->addChild('username', $username);
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
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $connection = loadXmlFile('connections.xml', 'connections');
        foreach ($connection->connection as $c) {
            if ((string) $c->username === $username && (string) $c->session_id === session_id()) {
                $c->logout = date('Y-m-d H:i:s');
                break;
            }
        }
        saveXmlFile($connection, 'connections.xml');
    }
    session_unset();
    session_destroy();
}

function DeleteUser($username) {
    $users = loadXmlFile('users.xml', 'users');
    foreach ($users->user as $u) {
        if ((string) $u->username === $username) {
            unset($u[0]);
            saveXmlFile($users, 'users.xml');
            return true;
        }
    }
    return false;
}