<?php
class Feedback {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($order_id, $rating, $comments) {
        $stmt = $this->pdo->prepare("INSERT INTO feedback (order_id, rating, comments) VALUES (?, ?, ?)");
        return $stmt->execute([$order_id, $rating, $comments]);
    }

    public function getFeedbackByOrder($order_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM feedback WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>