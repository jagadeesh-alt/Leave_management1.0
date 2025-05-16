<?php
include 'db.php';

$department_id = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;

if ($department_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM departments WHERE department_id = ?");
$stmt->bind_param("i", $department_id);

if ($stmt->execute()) {
    echo "✅ Department deleted successfully!";
} else {
    echo "❌ Failed to delete department: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>