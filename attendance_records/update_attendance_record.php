<?php
include 'db.php';

$record_id = isset($_POST['record_id']) ? (int)$_POST['record_id'] : 0;
$date = isset($_POST['date']) ? $_POST['date'] : '';
$clock_in = isset($_POST['clock_in']) && !empty($_POST['clock_in']) ? $_POST['clock_in'] : NULL;
$clock_out = isset($_POST['clock_out']) && !empty($_POST['clock_out']) ? $_POST['clock_out'] : NULL;
$status = isset($_POST['status']) ? $_POST['status'] : '';

$allowedStatuses = ['present','absent','late','half_day','holiday','weekend','on_leave'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($record_id <= 0 || empty($date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE attendance_records SET date = ?, clock_in = ?, clock_out = ?, status = ? WHERE record_id = ?");
$stmt->bind_param("sssii", $date, $clock_in, $clock_out, $status, $record_id);

if ($stmt->execute()) {
    echo "✅ Attendance record updated successfully!";
} else {
    echo "❌ Failed to update record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>