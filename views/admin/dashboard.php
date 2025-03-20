<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../views/auth/login.php');
    exit;
}
include '../layouts/header.php';
?>
<h2>Admin Dashboard</h2>
<p>Welcome, Admin! This is a placeholder for managing users, resolving disputes, and monitoring the system.</p>
<?php include '../layouts/footer.php'; ?>