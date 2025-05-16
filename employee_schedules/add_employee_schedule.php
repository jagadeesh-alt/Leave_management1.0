<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$schedule_id = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;
$effective_from = isset($_POST['effective_from']) ? $_POST['effective_from'] : '';
$effective_to = isset($_POST['effective_to']) && !empty($_POST['effective_to']) ? $_POST['effective_to'] : NULL;
$assigned_by = isset($_POST['assigned_by']) && !empty($_POST['assigned_by']) ? (int)$_POST['assigned_by'] : NULL;

if ($employee_id <= 0 || $schedule_id <= 0 || empty($effective_from)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO employee_schedules (
    employee_id, schedule_id, effective_from, effective_to, assigned_by
) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $employee_id, $schedule_id, $effective_from, $effective_to, $assigned_by);

if ($stmt->execute()) {
    echo "✅ Schedule assigned successfully!";
} else {
    echo "❌ Failed to assign schedule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>