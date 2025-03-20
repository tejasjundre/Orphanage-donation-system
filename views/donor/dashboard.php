<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header('Location: ../../views/auth/login.php');
    exit;
}
include '../layouts/header.php';
?>
<h2>Donor Dashboard</h2>
<a href="browse_requirements.php" class="btn btn-primary mb-3">Browse Requirements</a>
<?php include '../layouts/footer.php'; ?>