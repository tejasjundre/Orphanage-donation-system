<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once '../../config/db.php';
require_once '../../models/Requirement.php';

$requirementModel = new Requirement($pdo);
$requirement = $requirementModel->getRequirementById($_GET['requirement_id']);
include '../layouts/header.php';
?>
<h2>Donate to Requirement</h2>
<form action="../../controllers/DonationController.php" method="post">
    <input type="hidden" name="requirement_id" value="<?php echo $requirement['requirement_id']; ?>">
    <div class="mb-3">
        <label class="form-label">Requirement: <?php echo htmlspecialchars($requirement['item_name']); ?> (<?php echo $requirement['quantity']; ?> units)</label>
    </div>
    <div class="mb-3">
        <label for="donation_type" class="form-label">Donation Type</label>
        <select class="form-control" id="donation_type" name="donation_type" required>
            <option value="item">Donate Item</option>
            <option value="amount">Donate Fixed Amount</option>
        </select>
    </div>
    <div class="mb-3" id="amount_field" style="display: none;">
        <label for="amount" class="form-label">Amount ($)</label>
        <input type="number" class="form-control" id="amount" name="amount" step="0.01">
    </div>
    <button type="submit" name="donate" class="btn btn-primary">Donate</button>
</form>
<script>
document.getElementById('donation_type').addEventListener('change', function() {
    document.getElementById('amount_field').style.display = this.value === 'amount' ? 'block' : 'none';
});
</script>
<?php include '../layouts/footer.php'; ?>