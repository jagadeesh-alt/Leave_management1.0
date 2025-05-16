<?php
include 'db.php';

$setting_id = isset($_POST['setting_id']) ? (int)$_POST['setting_id'] : 0;

if ($setting_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM system_settings WHERE setting_id = ?");
$stmt->bind_param("i", $setting_id);

if ($stmt->execute()) {
    echo "✅ System setting deleted successfully!";
} else {
    echo "❌ Failed to delete setting: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>