<?php
include 'db.php';

$recipient_id = isset($_POST['recipient_id']) ? (int)$_POST['recipient_id'] : 0;
$sender_id = isset($_POST['sender_id']) && $_POST['sender_id'] !== '' ? (int)$_POST['sender_id'] : NULL;
$type = isset($_POST['type']) ? $_POST['type'] : '';
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$related_id = isset($_POST['related_id']) && $_POST['related_id'] !== '' ? (int)$_POST['related_id'] : NULL;
$related_type = isset($_POST['related_type']) ? trim($_POST['related_type']) : NULL;

$allowedTypes = ['leave','approval','attendance','payroll','system','other'];
if (!in_array($type, $allowedTypes)) {
    die("❌ Invalid notification type");
}

if ($recipient_id <= 0 || empty($type) || empty($title) || empty($message)) {
    die("❌ Required fields are missing");
}

$stmt = $conn->prepare("INSERT INTO notifications (
    recipient_id, sender_id, type, title, message, related_id, related_type
) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssii", 
    $recipient_id, $sender_id, $type, $title, $message, $related_id, $related_type
);

if ($stmt->execute()) {
    echo "✅ Notification sent successfully!";
} else {
    echo "❌ Failed to send notification: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>