<?php
include 'db.php';

$application_id = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';

$allowedStatuses = ['pending','approved','rejected','cancelled','recalled'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($application_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_applications SET status = ? WHERE application_id = ?");
$stmt->bind_param("si", $status, $application_id);

if ($stmt->execute()) {
    echo "✅ Leave status updated successfully!";
} else {
    echo "❌ Failed to update leave status: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>