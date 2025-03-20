<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'institution') {
    header('Location: ../../views/auth/login.php');
    exit;
}
include '../layouts/header.php';
?>
<h2>Post New Requirement</h2>
<form action="../../controllers/RequirementController.php" method="post">
    <div class="mb-3">
        <label for="item_name" class="form-label">Item Name</label>
        <input type="text" class="form-control" id="item_name" name="item_name" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <button type="submit" name="post_requirement" class="btn btn-primary">Submit</button>
</form>
<?php include '../layouts/footer.php'; ?>