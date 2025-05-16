<?php
include 'db.php';

$accrual_id = isset($_POST['accrual_id']) ? (int)$_POST['accrual_id'] : 0;

if ($accrual_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_accruals WHERE accrual_id = ?");
$stmt->bind_param("i", $accrual_id);

if ($stmt->execute()) {
    echo "✅ Accrual deleted successfully!";
} else {
    echo "❌ Failed to delete accrual: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>