<?php
class Requirement {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($institution_id, $item_name, $quantity, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO requirements (institution_id, item_name, quantity, description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$institution_id, $item_name, $quantity, $description]);
    }

    public function getOpenRequirements() {
        $stmt = $this->pdo->query("SELECT r.*, u.username as institution_name FROM requirements r JOIN users u ON r.institution_id = u.user_id WHERE r.status = 'open'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRequirementsByInstitution($institution_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM requirements WHERE institution_id = ?");
        $stmt->execute([$institution_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRequirementById($requirement_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM requirements WHERE requirement_id = ?");
        $stmt->execute([$requirement_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($requirement_id, $status) {
        $stmt = $this->pdo->prepare("UPDATE requirements SET status = ? WHERE requirement_id = ?");
        return $stmt->execute([$status, $requirement_id]);
    }

    public function getAverageConsumption($institution_id) {
        $stmt = $this->pdo->prepare("SELECT AVG(quantity) as avg_quantity FROM requirements WHERE institution_id = ? AND status = 'fulfilled'");
        $stmt->execute([$institution_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avg_quantity'] ?? 0;
    }
}
?>