<?php
require_once 'functions.php';

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';
$login = $_GET['login'] ?? '';
$register = $_GET['register'] ?? '';
$logout = $_GET['logout'] ?? '';
$deleteUser = $_GET['deleteUser'] ?? '';

if (isset($deleteUser) && $deleteUser === 'true' && isset($username)) {
    if (DeleteUser($username)) {
        echo "User deleted successfully.";
    } else {
        echo "User not found.";
    }
}

if (isset($logout) && $logout === 'true') {
    logout();
    echo "Logged out successfully.";
}

if (isset($login) && $login === 'true' && isset($username) && isset($password)) {
    if (login($username, $password)) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
}

if (isset($register) && $register === 'true' && isset($username) && isset($password) && $logout !== 'true') {
    if (register($username, $password)) {
        echo "Registration successful!";
    } else {
        echo "Username already exists.";
    }
}