<?php
include 'db.php';

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if ($user_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "✅ User deleted successfully!";
} else {
    echo "❌ Failed to delete user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>