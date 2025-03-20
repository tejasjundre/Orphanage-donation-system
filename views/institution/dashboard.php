<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'institution') {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once '../../config/db.php';
require_once '../../models/Requirement.php';
require_once '../../models/Order.php';

$requirementModel = new Requirement($pdo);
$orderModel = new Order($pdo);
$requirements = $requirementModel->getRequirementsByInstitution($_SESSION['user_id']);
$orders = $orderModel->getOrdersBySupplier($_SESSION['user_id']); // For feedback on delivered orders
?>
<?php include '../layouts/header.php'; ?>
<h2>Institution Dashboard</h2>
<a href="post_requirement.php" class="btn btn-primary mb-3">Post New Requirement</a>
<h3>Your Requirements</h3>
<table class="table">
    <thead>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requirements as $req): ?>
            <tr>
                <td><?php echo htmlspecialchars($req['item_name']); ?></td>
                <td><?php echo $req['quantity']; ?></td>
                <td><?php echo htmlspecialchars($req['description']); ?></td>
                <td><?php echo $req['status']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Delivered Orders (Provide Feedback)</h3>
<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): if ($order['status'] === 'delivered'): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo htmlspecialchars($order['item_name']); ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td><a href="feedback.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-info">Feedback</a></td>
            </tr>
        <?php endif; endforeach; ?>
    </tbody>
</table>
<?php include '../layouts/footer.php'; ?>