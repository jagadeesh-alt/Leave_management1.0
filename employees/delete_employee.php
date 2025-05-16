<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;

if ($employee_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);

if ($stmt->execute()) {
    echo "✅ Employee deleted successfully!";
} else {
    echo "❌ Failed to delete employee: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>