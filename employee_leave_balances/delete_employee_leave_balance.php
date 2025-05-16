<?php
include 'db.php';

$balance_id = isset($_POST['balance_id']) ? (int)$_POST['balance_id'] : 0;

if ($balance_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM employee_leave_balances WHERE balance_id = ?");
$stmt->bind_param("i", $balance_id);

if ($stmt->execute()) {
    echo "✅ Leave balance deleted successfully!";
} else {
    echo "❌ Failed to delete balance: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>