<?php
include 'db.php';

$position_id = isset($_POST['position_id']) ? (int)$_POST['position_id'] : 0;

if ($position_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM positions WHERE position_id = ?");
$stmt->bind_param("i", $position_id);

if ($stmt->execute()) {
    echo "✅ Position deleted successfully!";
} else {
    echo "❌ Failed to delete position: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>