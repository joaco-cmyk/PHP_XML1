<?php
require_once 'functions.php';

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';
$register = $_GET['register'] ?? '';
$logout = $_GET['logout'] ?? '';

if (isset($logout) && $logout === 'true') {
    logout();
    echo "Logged out successfully.";
}

if (isset($username) && isset($password) && $register !== 'true' && $logout !== 'true') {
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