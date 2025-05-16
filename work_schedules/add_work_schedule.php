<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$is_default = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

$days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
$scheduleData = [];

foreach ($days as $day) {
    $start = isset($_POST[$day.'_start']) && !empty($_POST[$day.'_start']) ? $_POST[$day.'_start'].":00" : NULL;
    $end = isset($_POST[$day.'_end']) && !empty($_POST[$day.'_end']) ? $_POST[$day.'_end'].":00" : NULL;

    $scheduleData[] = $start;
    $scheduleData[] = $end;
}

if (empty($name)) {
    die("❌ Schedule name is required");
}

// Reset any existing default schedules
if ($is_default) {
    $conn->query("UPDATE work_schedules SET is_default = 0 WHERE is_default = 1");
}

$stmt = $conn->prepare("INSERT INTO work_schedules (
    name, description, is_default,
    mon_start, mon_end,
    tue_start, tue_end,
    wed_start, wed_end,
    thu_start, thu_end,
    fri_start, fri_end,
    sat_start, sat_end,
    sun_start, sun_end
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

call_user_func_array([$stmt, 'bind_param'], array_merge(
    ["sssi", $name, $desc, $is_default],
    $scheduleData
));

if ($stmt->execute()) {
    echo "✅ Schedule added successfully!";
} else {
    echo "❌ Failed to add schedule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>