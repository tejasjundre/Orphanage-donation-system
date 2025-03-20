<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once '../../config/db.php';
require_once '../../models/Requirement.php';

$requirementModel = new Requirement($pdo);
$requirements = $requirementModel->getOpenRequirements();
include '../layouts/header.php';
?>
<h2>Browse Requirements</h2>
<table class="table">
    <thead>
        <tr>
            <th>Institution</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requirements as $req): ?>
            <tr>
                <td><?php echo htmlspecialchars($req['institution_name']); ?></td>
                <td><?php echo htmlspecialchars($req['item_name']); ?></td>
                <td><?php echo $req['quantity']; ?></td>
                <td><?php echo htmlspecialchars($req['description']); ?></td>
                <td><a href="donate.php?requirement_id=<?php echo $req['requirement_id']; ?>" class="btn btn-success">Donate</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../layouts/footer.php'; ?>