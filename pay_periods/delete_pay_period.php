<?php
include 'db.php';

$period_id = isset($_POST['period_id']) ? (int)$_POST['period_id'] : 0;

if ($period_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM pay_periods WHERE period_id = ?");
$stmt->bind_param("i", $period_id);

if ($stmt->execute()) {
    echo "✅ Pay period deleted successfully!";
} else {
    echo "❌ Failed to delete pay period: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>