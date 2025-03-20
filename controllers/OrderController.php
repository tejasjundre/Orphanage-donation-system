<?php
session_start();
require_once '../config/db.php';
require_once '../models/Order.php';

$orderModel = new Order($pdo);

if (isset($_POST['update_status']) && $_SESSION['role'] === 'supplier') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $orderModel->updateStatus($order_id, $status);
    header('Location: ../views/supplier/dashboard.php');
    exit;
}
?>