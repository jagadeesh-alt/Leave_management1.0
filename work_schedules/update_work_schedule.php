<?php
include 'db.php';

$schedule_id = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$is_default = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

$days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
$updateFields = [];
$params = [];
$values = [];

if ($schedule_id <= 0 || empty($name)) {
    die("❌ Invalid request");
}

// Reset other defaults
if ($is_default) {
    $conn->query("UPDATE work_schedules SET is_default = 0 WHERE schedule_id != $schedule_id");
}

// Build SQL and bind values
$updateFields[] = "name = ?";
$params[] = "s";
$values[] = $name;

$updateFields[] = "description = ?";
$params[] = "s";
$values[] = isset($_POST['description']) ? trim($_POST['description']) : NULL;

$updateFields[] = "is_default = ?";
$params[] = "i";
$values[] = $is_default;

foreach ($days as $day) {
    $start = isset($_POST[$day."_start"]) ? $_POST[$day."_start"].":00" : NULL;
    $end = isset($_POST[$day."_end"]) ? $_POST[$day."_end"].":00" : NULL;

    $updateFields[] = "$day"."_start = ?";
    $params[] = "s";
    $values[] = $start;

    $updateFields[] = "$day"."_end = ?";
    $params[] = "s";
    $values[] = $end;
}

$sql = "UPDATE work_schedules SET " . implode(', ', $updateFields) . " WHERE schedule_id = ?";
$params[] = "i";
$values[] = $schedule_id;

$stmt = $conn->prepare($sql);
call_user_func_array([$stmt, 'bind_param'], $params);
array_unshift($values, $sql); // For debugging only

if ($stmt->execute()) {
    echo "✅ Schedule updated successfully!";
} else {
    echo "❌ Failed to update schedule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>