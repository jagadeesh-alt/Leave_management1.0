<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) && !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;
$is_primary = isset($_POST['is_primary']) ? (int)$_POST['is_primary'] : 1;

if ($id <= 0 || empty($start_date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE employee_position_history SET start_date = ?, end_date = ?, is_primary = ? WHERE id = ?");
$stmt->bind_param("ssii", $start_date, $end_date, $is_primary, $id);

if ($stmt->execute()) {
    echo "✅ Record updated successfully!";
} else {
    echo "❌ Failed to update record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>