<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';

if (empty($name)) {
    die("❌ Permission name is required");
}

$stmt = $conn->prepare("INSERT INTO permissions (name, description, category) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $description, $category);

if ($stmt->execute()) {
    echo "✅ Permission added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A permission with this name already exists.";
    } else {
        echo "❌ Failed to add permission: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>