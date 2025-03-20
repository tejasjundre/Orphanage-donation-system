<?php
class Donation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createItemDonation($donor_id, $requirement_id, $item_name, $quantity) {
        $stmt = $this->pdo->prepare("INSERT INTO donations (donor_id, requirement_id) VALUES (?, ?)");
        $stmt->execute([$donor_id, $requirement_id]);
        $donation_id = $this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare("INSERT INTO donation_items (donation_id, item_name, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$donation_id, $item_name, $quantity]);
        return $donation_id;
    }

    public function createAmountDonation($donor_id, $amount) {
        $stmt = $this->pdo->prepare("INSERT INTO donations (donor_id, amount) VALUES (?, ?)");
        $stmt->execute([$donor_id, $amount]);
        return $this->pdo->lastInsertId();
    }
}
?>