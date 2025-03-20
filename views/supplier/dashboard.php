<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'supplier') {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once '../../config/db.php';
require_once '../../models/Order.php';

$orderModel = new Order($pdo);
$orders = $orderModel->getOrdersBySupplier($_SESSION['user_id']);
include '../layouts/header.php';
?>
<h2>Supplier Dashboard</h2>
<h3>Your Orders</h3>
<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo htmlspecialchars($order['item_name']); ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td>
                    <form action="../../controllers/OrderController.php" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        <select name="status" class="form-select d-inline w-auto">
                            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="packed" <?php echo $order['status'] === 'packed' ? 'selected' : ''; ?>>Packed</option>
                            <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                            <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../layouts/footer.php'; ?>