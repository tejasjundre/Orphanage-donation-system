<?php
session_start();
require_once '../config/db.php';
require_once '../models/User.php';

$userModel = new User($pdo);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $address = $_POST['address'];
    $contact_info = $_POST['contact_info'];
    if ($userModel->register($username, $password, $email, $role, $address, $contact_info)) {
        header('Location: ../views/auth/login.php');
        exit;
    } else {
        echo "Registration failed.";
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $userModel->login($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../views/{$user['role']}/dashboard.php");
        exit;
    } else {
        echo "Invalid credentials.";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../views/auth/login.php');
    exit;
}
?>