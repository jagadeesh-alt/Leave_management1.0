<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$code = isset($_POST['code']) && $_POST['code'] !== '' ? trim($_POST['code']) : NULL;
$parentId = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : NULL;
$managerId = isset($_POST['manager_id']) && $_POST['manager_id'] !== '' ? (int)$_POST['manager_id'] : NULL;
$costCenter = isset($_POST['cost_center']) && $_POST['cost_center'] !== '' ? trim($_POST['cost_center']) : NULL;
$description = isset($_POST['description']) && $_POST['description'] !== '' ? trim($_POST['description']) : NULL;

if (empty($name)) {
    die("❌ Department name is required");
}

$stmt = $conn->prepare("INSERT INTO departments (name, code, parent_department_id, manager_id, cost_center, description) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiis", $name, $code, $parentId, $managerId, $costCenter, $description);

if ($stmt->execute()) {
    echo "✅ Department added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A department with this code already exists.";
    } else {
        echo "❌ Failed to add department: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>