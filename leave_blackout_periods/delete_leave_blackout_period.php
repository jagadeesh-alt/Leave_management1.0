<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_blackout_periods WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Blackout period deleted successfully!";
} else {
    echo "❌ Failed to delete blackout period: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>