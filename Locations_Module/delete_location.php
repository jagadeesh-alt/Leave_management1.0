<?php
include 'db.php';

$location_id = isset($_POST['location_id']) ? (int)$_POST['location_id'] : 0;

if ($location_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM locations WHERE location_id = ?");
$stmt->bind_param("i", $location_id);

if ($stmt->execute()) {
    echo "✅ Location deleted successfully!";
} else {
    echo "❌ Failed to delete location: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>