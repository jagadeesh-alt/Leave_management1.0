<?php
include 'db.php';

$record_id = isset($_POST['record_id']) ? (int)$_POST['record_id'] : 0;

if ($record_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM attendance_records WHERE record_id = ?");
$stmt->bind_param("i", $record_id);

if ($stmt->execute()) {
    echo "✅ Attendance record deleted successfully!";
} else {
    echo "❌ Failed to delete record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>