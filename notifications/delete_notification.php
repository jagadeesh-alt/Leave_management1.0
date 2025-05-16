<?php
include 'db.php';

$notification_id = isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : 0;

if ($notification_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM notifications WHERE notification_id = ?");
$stmt->bind_param("i", $notification_id);

if ($stmt->execute()) {
    echo "✅ Notification deleted successfully!";
} else {
    echo "❌ Failed to delete notification: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>