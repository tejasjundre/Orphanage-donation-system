<?php
session_start();
require_once '../config/db.php';
require_once '../models/Requirement.php';

$requirementModel = new Requirement($pdo);

if (isset($_POST['post_requirement']) && $_SESSION['role'] === 'institution') {
    $institution_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $avg = $requirementModel->getAverageConsumption($institution_id);
    if ($quantity > $avg * 1.5 && $avg > 0) {
        echo "Warning: Quantity exceeds 150% of your average consumption.";
    } else {
        if ($requirementModel->create($institution_id, $item_name, $quantity, $description)) {
            header('Location: ../views/institution/dashboard.php');
            exit;
        } else {
            echo "Failed to post requirement.";
        }
    }
}
?>