<?php
include 'db.php';

$adjustment_id = isset($_POST['adjustment_id']) ? (int)$_POST['adjustment_id'] : 0;

if ($adjustment_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM attendance_adjustments WHERE adjustment_id = ?");
$stmt->bind_param("i", $adjustment_id);

if ($stmt->execute()) {
    echo "✅ Adjustment deleted successfully!";
} else {
    echo "❌ Failed to delete adjustment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>