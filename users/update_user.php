<?php
include 'db.php';

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

if ($user_id <= 0 || empty($username) || empty($email) || $role_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role_id = ? WHERE user_id = ?");
$stmt->bind_param("ssii", $username, $email, $role_id, $user_id);

if ($stmt->execute()) {
    echo "✅ User updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A user with this username or email already exists.";
    } else {
        echo "❌ Failed to update user: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>