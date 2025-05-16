<?php
include 'db.php';

$department_id = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$code = isset($_POST['code']) && $_POST['code'] !== '' ? trim($_POST['code']) : NULL;
$parentId = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : NULL;
$managerId = isset($_POST['manager_id']) && $_POST['manager_id'] !== '' ? (int)$_POST['manager_id'] : NULL;

if ($department_id <= 0 || empty($name)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE departments SET name = ?, code = ?, parent_department_id = ?, manager_id = ? WHERE department_id = ?");
$stmt->bind_param("ssiiii", $name, $code, $parentId, $managerId, $department_id);

if ($stmt->execute()) {
    echo "✅ Department updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A department with this code already exists.";
    } else {
        echo "❌ Failed to update department: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>