<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("SELECT file_path FROM leave_attachments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();

if (!empty($file_path) && file_exists($file_path)) {
    unlink($file_path); // Delete physical file
}

$stmt = $conn->prepare("DELETE FROM leave_attachments WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Attachment deleted successfully!";
} else {
    echo "❌ Failed to delete attachment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>