<?php
include 'db.php';

$log_id = isset($_POST['log_id']) ? (int)$_POST['log_id'] : 0;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$table_name = isset($_POST['table_name']) ? trim($_POST['table_name']) : '';
$record_id = isset($_POST['record_id']) && $_POST['record_id'] !== '' ? (int)$_POST['record_id'] : NULL;

if ($log_id <= 0 || empty($action) || empty($table_name)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE audit_logs SET action = ?, table_name = ?, record_id = ? WHERE log_id = ?");
$stmt->bind_param("ssii", $action, $table_name, $record_id, $log_id);

if ($stmt->execute()) {
    echo "✅ Audit log updated successfully!";
} else {
    echo "❌ Failed to update audit log: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>