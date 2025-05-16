<?php
include 'db.php';

$rule_id = isset($_POST['rule_id']) ? (int)$_POST['rule_id'] : 0;
$accrual = isset($_POST['accrual_frequency']) ? $_POST['accrual_frequency'] : 'none';
$accrual_rate = isset($_POST['accrual_rate']) ? floatval($_POST['accrual_rate']) : 0.00;
$max_balance = isset($_POST['max_balance']) && !empty($_POST['max_balance']) ? floatval($_POST['max_balance']) : NULL;

if ($rule_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_policy_rules SET accrual_frequency = ?, accrual_rate = ?, max_balance = ? WHERE rule_id = ?");
$stmt->bind_param("ssdi", $accrual, $accrual_rate, $max_balance, $rule_id);

if ($stmt->execute()) {
    echo "✅ Rule updated successfully!";
} else {
    echo "❌ Failed to update rule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>