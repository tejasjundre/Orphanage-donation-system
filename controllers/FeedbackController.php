<?php
session_start();
require_once '../config/db.php';
require_once '../models/Feedback.php';

$feedbackModel = new Feedback($pdo);

if (isset($_POST['submit_feedback']) && $_SESSION['role'] === 'institution') {
    $order_id = $_POST['order_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];
    if ($feedbackModel->create($order_id, $rating, $comments)) {
        header('Location: ../views/institution/dashboard.php');
        exit;
    } else {
        echo "Failed to submit feedback.";
    }
}
?>