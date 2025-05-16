<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$date = isset($_POST['date']) ? $_POST['date'] : '';
$clock_in = isset($_POST['clock_in']) && !empty($_POST['clock_in']) ? $_POST['clock_in'] : NULL;
$clock_out = isset($_POST['clock_out']) && !empty($_POST['clock_out']) ? $_POST['clock_out'] : NULL;
$status = isset($_POST['status']) ? $_POST['status'] : '';
$leave_app_id = isset($_POST['leave_application_id']) && !empty($_POST['leave_application_id']) ? (int)$_POST['leave_application_id'] : NULL;
$holiday_id = isset($_POST['holiday_id']) && !empty($_POST['holiday_id']) ? (int)$_POST['holiday_id'] : NULL;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : NULL;
$verified_by = isset($_POST['verified_by']) && !empty($_POST['verified_by']) ? (int)$_POST['verified_by'] : NULL;

$allowedStatuses = ['present','absent','late','half_day','holiday','weekend','on_leave'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($employee_id <= 0 || empty($date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO attendance_records (
    employee_id, date, clock_in, clock_out, status,
    leave_application_id, holiday_id, notes, verified_by
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississsisi", 
    $employee_id, $date, $clock_in, $clock_out, $status,
    $leave_app_id, $holiday_id, $notes, $verified_by
);

if ($stmt->execute()) {
    echo "✅ Attendance record added successfully!";
} else {
    echo "❌ Failed to add record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>