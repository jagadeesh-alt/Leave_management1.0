<?php
include 'db.php';

$accrual_id = isset($_POST['accrual_id']) ? (int)$_POST['accrual_id'] : 0;
$accrual_date = isset($_POST['accrual_date']) ? $_POST['accrual_date'] : '';
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;

if ($accrual_id <= 0 || empty($accrual_date) || $amount < 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_accruals SET accrual_date = ?, amount = ? WHERE accrual_id = ?");
$stmt->bind_param("sdi", $accrual_date, $amount, $accrual_id);

if ($stmt->execute()) {
    echo "✅ Accrual updated successfully!";
} else {
    echo "❌ Failed to update accrual: " . $stmt->error;
}

$stmt->close();
$conn->close();
?> 