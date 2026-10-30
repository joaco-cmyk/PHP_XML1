<?php
require_once 'functions.php';
session_start();
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';
$action = $_GET['action'] ?? '';

if (isset($action) && $action === 'deleteUser' && isset($username)) {
    if (DeleteUser($username)) {
        echo "User deleted successfully.";
    } else {
        echo "User not found.";
    }
}

if (isset($action) && $action === 'logout') {
    logout();
    echo "Logged out successfully.";
}

if (isset($action) && $action === 'login' && isset($username) && isset($password)) {
    if (login($username, $password)) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
}

if (isset($action) && $action === 'register' && isset($username) && isset($password)) {
    if (register($username, $password)) {
        echo "Registration successful!";
    } else {
        echo "Username already exists.";
    }
}