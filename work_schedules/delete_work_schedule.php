<?php
include 'db.php';

$schedule_id = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;

if ($schedule_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM work_schedules WHERE schedule_id = ?");
$stmt->bind_param("i", $schedule_id);

if ($stmt->execute()) {
    echo "✅ Schedule deleted successfully!";
} else {
    echo "❌ Failed to delete schedule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>