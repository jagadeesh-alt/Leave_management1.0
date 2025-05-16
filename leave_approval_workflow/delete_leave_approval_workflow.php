<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_approval_workflow WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Approval step deleted successfully!";
} else {
    echo "❌ Failed to delete approval step: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>