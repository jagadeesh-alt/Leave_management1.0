<?php
include 'db.php';

$adjustment_id = isset($_POST['adjustment_id']) ? (int)$_POST['adjustment_id'] : 0;
$old_value = isset($_POST['old_value']) ? trim($_POST['old_value']) : NULL;
$new_value = isset($_POST['new_value']) ? trim($_POST['new_value']) : NULL;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

if ($adjustment_id <= 0 || empty($reason)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE attendance_adjustments SET old_value = ?, new_value = ?, reason = ? WHERE adjustment_id = ?");
$stmt->bind_param("sssi", $old_value, $new_value, $reason, $adjustment_id);

if ($stmt->execute()) {
    echo "✅ Adjustment updated successfully!";
} else {
    echo "❌ Failed to update adjustment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>