<?php
include 'db.php';

$application_id = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;

if ($application_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_applications WHERE application_id = ?");
$stmt->bind_param("i", $application_id);

if ($stmt->execute()) {
    echo "✅ Leave application deleted successfully!";
} else {
    echo "❌ Failed to delete: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>