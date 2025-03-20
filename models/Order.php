<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectSuppliers($quantity) {
        if ($quantity > 50) { // Large donation rule
            $stmt = $this->pdo->query("SELECT user_id FROM users WHERE role = 'supplier' AND user_id NOT IN (
                SELECT supplier_id FROM supplier_assignments WHERE assignment_date > NOW() - INTERVAL 1 DAY
            ) ORDER BY (SELECT COUNT(*) FROM supplier_assignments sa WHERE sa.supplier_id = users.user_id) LIMIT 2");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->pdo->query("SELECT user_id FROM users WHERE role = 'supplier' AND user_id NOT IN (
                SELECT supplier_id FROM supplier_assignments WHERE assignment_date > NOW() - INTERVAL 1 DAY
            ) ORDER BY (SELECT COUNT(*) FROM supplier_assignments sa WHERE sa.supplier_id = users.user_id) LIMIT 1");
            return [$stmt->fetch(PDO::FETCH_ASSOC)];
        }
    }

    public function create($supplier_id, $donation_id, $item_name, $quantity, $total_cost) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (supplier_id, donation_id, total_cost) VALUES (?, ?, ?)");
        $stmt->execute([$supplier_id, $donation_id, $total_cost]);
        $order_id = $this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, item_name, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$order_id, $item_name, $quantity]);
        $stmt = $this->pdo->prepare("INSERT INTO supplier_assignments (supplier_id, order_id) VALUES (?, ?)");
        $stmt->execute([$supplier_id, $order_id]);
        return $order_id;
    }

    public function getOrdersBySupplier($supplier_id) {
        $stmt = $this->pdo->prepare("SELECT o.order_id, o.status, o.payment_status, oi.item_name, oi.quantity 
            FROM orders o JOIN order_items oi ON o.order_id = oi.order_id 
            WHERE o.supplier_id = ?");
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($order_id, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->execute([$status, $order_id]);
        if ($status === 'delivered') {
            $stmt = $this->pdo->prepare("UPDATE orders SET payment_status = 'paid' WHERE order_id = ?");
            $stmt->execute([$order_id]);
        }
    }
}
?>