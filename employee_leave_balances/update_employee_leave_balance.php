<?php
include 'db.php';

$balance_id = isset($_POST['balance_id']) ? (int)$_POST['balance_id'] : 0;
$year = isset($_POST['year']) ? intval($_POST['year']) : 0;
$total_allocated = isset($_POST['total_allocated']) ? floatval($_POST['total_allocated']) : 0.00;
$total_used = isset($_POST['total_used']) ? floatval($_POST['total_used']) : 0.00;

if ($balance_id <= 0 || $year <= 1900 || $total_allocated < 0 || $total_used < 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE employee_leave_balances SET year = ?, total_allocated = ?, total_used = ? WHERE balance_id = ?");
$stmt->bind_param("iddi", $year, $total_allocated, $total_used, $balance_id);

if ($stmt->execute()) {
    echo "✅ Leave balance updated successfully!";
} else {
    echo "❌ Failed to update balance: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>