<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$position_id = isset($_POST['position_id']) ? (int)$_POST['position_id'] : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) && !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;
$reporting_to = isset($_POST['reporting_to']) && !empty($_POST['reporting_to']) ? (int)$_POST['reporting_to'] : NULL;
$is_primary = isset($_POST['is_primary']) ? (int)$_POST['is_primary'] : 1;

if ($employee_id <= 0 || $position_id <= 0 || empty($start_date)) {
    die("❌ Required fields are missing");
}

$stmt = $conn->prepare("INSERT INTO employee_position_history (
    employee_id, position_id, start_date, end_date, reporting_to, is_primary
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissii", $employee_id, $position_id, $start_date, $end_date, $reporting_to, $is_primary);

if ($stmt->execute()) {
    echo "✅ Record added successfully!";
} else {
    echo "❌ Failed to add record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>