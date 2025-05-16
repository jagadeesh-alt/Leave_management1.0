<?php
include 'db.php';

// Get POST data with validation
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : '';
$is_system = isset($_POST['is_system']) ? (int)$_POST['is_system'] : 0;

// Validate required fields
if ($role_id <= 0 || empty($name)) {
    die("❌ Invalid request");
}

// Prepare and execute the statement
$stmt = $conn->prepare("UPDATE roles SET name = ?, description = ?, is_system = ? WHERE role_id = ?");
$stmt->bind_param("ssii", $name, $desc, $is_system, $role_id);

if ($stmt->execute()) {
    echo "✅ Role updated successfully!";
} else {
    // Check for duplicate entry error
    if ($conn->errno == 1062) {
        echo "❌ Role with this name already exists";
    } else {
        echo "❌ Failed to update role: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>