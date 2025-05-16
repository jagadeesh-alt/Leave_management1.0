<?php
include 'db.php';

$policy_id = isset($_POST['policy_id']) ? (int)$_POST['policy_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$accrual_frequency = isset($_POST['accrual_frequency']) ? $_POST['accrual_frequency'] : 'none';
$accrual_rate = isset($_POST['accrual_rate']) ? floatval($_POST['accrual_rate']) : 0.00;
$max_balance = isset($_POST['max_balance']) && !empty($_POST['max_balance']) ? floatval($_POST['max_balance']) : NULL;
$tenure_min_days = isset($_POST['tenure_min_days']) ? (int)$_POST['tenure_min_days'] : 0;
$tenure_max_days = isset($_POST['tenure_max_days']) && !empty($_POST['tenure_max_days']) ? (int)$_POST['tenure_max_days'] : NULL;
$carry_forward_limit = isset($_POST['carry_forward_limit']) && !empty($_POST['carry_forward_limit']) ? (int)$_POST['carry_forward_limit'] : NULL;
$carry_forward_expiry_months = isset($_POST['carry_forward_expiry_months']) && !empty($_POST['carry_forward_expiry_months']) ? (int)$_POST['carry_forward_expiry_months'] : NULL;

if ($policy_id <= 0 || $type_id <= 0) {
    die("❌ Policy and Leave Type are required");
}

$stmt = $conn->prepare("INSERT INTO leave_policy_rules (
    policy_id, type_id, accrual_frequency, accrual_rate, max_balance,
    tenure_min_days, tenure_max_days, carry_forward_limit, carry_forward_expiry_months
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissdiiii", 
    $policy_id, $type_id, $accrual_frequency, $accrual_rate, $max_balance,
    $tenure_min_days, $tenure_max_days, $carry_forward_limit, $carry_forward_expiry_months
);

if ($stmt->execute()) {
    echo "✅ Rule added successfully!";
} else {
    echo "❌ Failed to add rule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>