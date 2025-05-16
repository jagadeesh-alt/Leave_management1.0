<?php
include 'db.php';

$log_id = isset($_POST['log_id']) ? (int)$_POST['log_id'] : 0;

if ($log_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM audit_logs WHERE log_id = ?");
$stmt->bind_param("i", $log_id);

if ($stmt->execute()) {
    echo "✅ Audit log deleted successfully!";
} else {
    echo "❌ Failed to delete audit log: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>