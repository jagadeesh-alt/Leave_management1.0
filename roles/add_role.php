<?php
include 'db.php';

// Get POST data with validation
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : '';
$is_system = isset($_POST['is_system']) ? (int)$_POST['is_system'] : 0;

// Validate required fields
if (empty($name)) {
    die("❌ Role name is required");
}

// Prepare and execute the statement
$stmt = $conn->prepare("INSERT INTO roles (name, description, is_system) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $desc, $is_system);

if ($stmt->execute()) {
    echo "✅ Role added successfully!";
} else {
    // Check for duplicate entry error
    if ($conn->errno == 1062) {
        echo "❌ Role with this name already exists";
    } else {
        echo "❌ Failed to add role: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>