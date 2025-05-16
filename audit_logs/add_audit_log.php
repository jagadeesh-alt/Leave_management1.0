<?php
include 'db.php';

$user_id = isset($_POST['user_id']) && $_POST['user_id'] !== '' ? (int)$_POST['user_id'] : NULL;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$table_name = isset($_POST['table_name']) ? trim($_POST['table_name']) : '';
$record_id = isset($_POST['record_id']) && $_POST['record_id'] !== '' ? (int)$_POST['record_id'] : NULL;
$old_values = isset($_POST['old_values']) ? trim($_POST['old_values']) : NULL;
$new_values = isset($_POST['new_values']) ? trim($_POST['new_values']) : NULL;
$ip_address = isset($_POST['ip_address']) ? trim($_POST['ip_address']) : NULL;
$user_agent = isset($_POST['user_agent']) ? trim($_POST['user_agent']) : NULL;

if (empty($action) || empty($table_name)) {
    die("❌ Invalid request: Action and Table Name are required");
}

$stmt = $conn->prepare("INSERT INTO audit_logs (
    user_id, action, table_name, record_id, old_values, new_values,
    ip_address, user_agent
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisss", 
    $user_id, $action, $table_name, $record_id, $old_values, $new_values, $ip_address, $user_agent
);

if ($stmt->execute()) {
    echo "✅ Audit log added successfully!";
} else {
    echo "❌ Failed to add audit log: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>