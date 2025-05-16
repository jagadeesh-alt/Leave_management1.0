<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM employee_position_history WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Record deleted successfully!";
} else {
    echo "❌ Failed to delete record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>