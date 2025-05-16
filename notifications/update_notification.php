<?php
include 'db.php';

$notification_id = isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$is_read = isset($_POST['is_read']) ? (int)$_POST['is_read'] : 0;

if ($notification_id <= 0 || empty($title)) {
    die("❌ Invalid request");
}

$read_at = $is_read ? "NOW()" : "NULL";

$stmt = $conn->prepare("UPDATE notifications SET title = ?, is_read = ?, read_at = $read_at WHERE notification_id = ?");
$stmt->bind_param("sii", $title, $is_read, $notification_id);

if ($stmt->execute()) {
    echo "✅ Notification updated successfully!";
} else {
    echo "❌ Failed to update notification: " . $stmt->error;
}

$stmt->close();
$conn->close();
?> 