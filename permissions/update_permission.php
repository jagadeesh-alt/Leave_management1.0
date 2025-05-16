<?php
include 'db.php';

$permission_id = isset($_POST['permission_id']) ? (int)$_POST['permission_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';

if ($permission_id <= 0 || empty($name)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE permissions SET name = ?, description = ?, category = ? WHERE permission_id = ?");
$stmt->bind_param("sssi", $name, $description, $category, $permission_id);

if ($stmt->execute()) {
    echo "✅ Permission updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A permission with this name already exists.";
    } else {
        echo "❌ Failed to update permission: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>