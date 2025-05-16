<?php
include 'db.php';

// Get POST data with validation
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

// Validate required fields
if ($role_id <= 0) {
    die("❌ Invalid request");
}

// Prepare and execute the statement
$stmt = $conn->prepare("DELETE FROM roles WHERE role_id = ?");
$stmt->bind_param("i", $role_id);

if ($stmt->execute()) {
    echo "✅ Role deleted successfully!";
} else {
    echo "❌ Failed to delete role: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>