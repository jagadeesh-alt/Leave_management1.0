<?php
include 'db.php';

$permission_id = isset($_POST['permission_id']) ? (int)$_POST['permission_id'] : 0;

if ($permission_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM permissions WHERE permission_id = ?");
$stmt->bind_param("i", $permission_id);

if ($stmt->execute()) {
    echo "✅ Permission deleted successfully!";
} else {
    echo "❌ Failed to delete permission: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>