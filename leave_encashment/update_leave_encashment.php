<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$days_encashed = isset($_POST['days_encashed']) ? floatval($_POST['days_encashed']) : 0.00;
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';

$allowedStatuses = ['pending','approved','rejected','processed'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($id <= 0 || $days_encashed <= 0 || $amount <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_encashment SET days_encashed = ?, amount = ?, status = ? WHERE id = ?");
$stmt->bind_param("ddsi", $days_encashed, $amount, $status, $id);

if ($stmt->execute()) {
    echo "✅ Encashment updated successfully!";
} else {
    echo "❌ Failed to update encashment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>