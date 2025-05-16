<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$accrual_date = isset($_POST['accrual_date']) ? $_POST['accrual_date'] : '';
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;
$policy_rule_id = isset($_POST['policy_rule_id']) && !empty($_POST['policy_rule_id']) ? (int)$_POST['policy_rule_id'] : NULL;
$processed_by = isset($_POST['processed_by']) && !empty($_POST['processed_by']) ? (int)$_POST['processed_by'] : NULL;

if ($employee_id <= 0 || $type_id <= 0 || empty($accrual_date) || $amount < 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO leave_accruals (
    employee_id, type_id, accrual_date, amount, policy_rule_id, processed_by
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissii", $employee_id, $type_id, $accrual_date, $amount, $policy_rule_id, $processed_by);

if ($stmt->execute()) {
    echo "✅ Accrual added successfully!";
} else {
    echo "❌ Failed to add accrual: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>