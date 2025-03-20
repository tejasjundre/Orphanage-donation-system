<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'institution') {
    header('Location: ../../views/auth/login.php');
    exit;
}
include '../layouts/header.php';
?>
<h2>Provide Feedback</h2>
<form action="../../controllers/FeedbackController.php" method="post">
    <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">
    <div class="mb-3">
        <label for="rating" class="form-label">Rating (1-5)</label>
        <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
    </div>
    <div class="mb-3">
        <label for="comments" class="form-label">Comments</label>
        <textarea class="form-control" id="comments" name="comments" required></textarea>
    </div>
    <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
</form>
<?php include '../layouts/footer.php'; ?>