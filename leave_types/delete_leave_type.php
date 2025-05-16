<?php
include 'db.php';

$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;

if ($type_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_types WHERE type_id = ?");
$stmt->bind_param("i", $type_id);

if ($stmt->execute()) {
    echo "✅ Leave type deleted successfully!";
} else {
    echo "❌ Failed to delete leave type: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>