<?php
// Start the session to check user authentication
session_start();

// Redirect to login if the user is not a supplier
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'supplier') {
    header('Location: ../auth/login.php');
    exit;
}

// Include database connection and Order model
require_once '../../config/db.php';
require_once '../../models/Order.php';

// Initialize the Order model with the database connection
$orderModel = new Order($pdo);

// Fetch orders assigned to this supplier
$orders = $orderModel->getOrdersBySupplier($_SESSION['user_id']);

// Include the header layout
include '../layouts/header.php';
?>

<!-- Page content -->
<h2>Supplier Orders</h2>
<table class="table table-bordered">
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
                    <!-- Form to update order status -->
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

<?php
// Include the footer layout
include '../layouts/footer.php';
?>