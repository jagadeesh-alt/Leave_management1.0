<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$days = isset($_POST['days']) ? floatval($_POST['days']) : 0.00;
$impact_type = isset($_POST['impact_type']) ? $_POST['impact_type'] : '';
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;

$allowedTypes = ['deduction', 'addition'];
if (!in_array($impact_type, $allowedTypes)) {
    die("❌ Invalid impact type selected");
}

if ($id <= 0 || empty($impact_type) || $days <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_impact_on_payroll SET days = ?, impact_type = ?, amount = ? WHERE id = ?");
$stmt->bind_param("dssi", $days, $impact_type, $amount, $id);

if ($stmt->execute()) {
    echo "✅ Leave impact updated successfully!";
} else {
    echo "❌ Failed to update impact: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>