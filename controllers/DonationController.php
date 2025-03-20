<?php
session_start();
require_once '../config/db.php';
require_once '../models/Donation.php';
require_once '../models/Order.php';
require_once '../models/Requirement.php';

$donationModel = new Donation($pdo);
$orderModel = new Order($pdo);
$requirementModel = new Requirement($pdo);

if (isset($_POST['donate']) && $_SESSION['role'] === 'donor') {
    $donor_id = $_SESSION['user_id'];
    $requirement_id = $_POST['requirement_id'];
    $donation_type = $_POST['donation_type'];

    $requirement = $requirementModel->getRequirementById($requirement_id);
    if (!$requirement || $requirement['status'] !== 'open') {
        echo "Requirement not available.";
        exit;
    }

    if ($donation_type === 'item') {
        $donation_id = $donationModel->createItemDonation(
            $donor_id,
            $requirement_id,
            $requirement['item_name'],
            $requirement['quantity']
        );
        $suppliers = $orderModel->selectSuppliers($requirement['quantity']);
        $quantity_per_supplier = $requirement['quantity'] / count($suppliers);
        foreach ($suppliers as $supplier) {
            $orderModel->create(
                $supplier['user_id'],
                $donation_id,
                $requirement['item_name'],
                ceil($quantity_per_supplier),
                ceil($quantity_per_supplier * 5) // Simulated cost: $5 per unit
            );
        }
        $requirementModel->updateStatus($requirement_id, 'fulfilled');
    } else { // Fixed amount
        $amount = $_POST['amount'];
        $donation_id = $donationModel->createAmountDonation($donor_id, $amount);
        $suppliers = $orderModel->selectSuppliers($requirement['quantity']);
        $orderModel->create(
            $suppliers[0]['user_id'],
            $donation_id,
            $requirement['item_name'],
            $requirement['quantity'],
            $amount
        );
        $requirementModel->updateStatus($requirement_id, 'fulfilled');
    }
    header('Location: ../views/donor/dashboard.php');
    exit;
}
?>