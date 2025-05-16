<?php
include 'db.php';

$record_id = isset($_POST['record_id']) ? (int)$_POST['record_id'] : 0;
$adjusted_by = isset($_POST['adjusted_by']) ? (int)$_POST['adjusted_by'] : 0;
$adjustment_type = isset($_POST['adjustment_type']) ? $_POST['adjustment_type'] : '';
$old_value = isset($_POST['old_value']) ? trim($_POST['old_value']) : NULL;
$new_value = isset($_POST['new_value']) ? trim($_POST['new_value']) : NULL;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

$allowedTypes = ['clock_in', 'clock_out', 'status', 'notes'];
if (!in_array($adjustment_type, $allowedTypes)) {
    die("❌ Invalid adjustment type selected");
}

if ($record_id <= 0 || $adjusted_by <= 0 || empty($adjustment_type) || empty($reason)) {
    die("❌ Required fields are missing");
}

$stmt = $conn->prepare("INSERT INTO attendance_adjustments (
    record_id, adjusted_by, adjustment_type, old_value, new_value, reason
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssss", 
    $record_id, $adjusted_by, $adjustment_type, $old_value, $new_value, $reason
);

if ($stmt->execute()) {
    echo "✅ Adjustment added successfully!";
} else {
    echo "❌ Failed to add adjustment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>