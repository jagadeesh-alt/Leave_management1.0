<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_encashment WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Encashment deleted successfully!";
} else {
    echo "❌ Failed to delete encashment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>