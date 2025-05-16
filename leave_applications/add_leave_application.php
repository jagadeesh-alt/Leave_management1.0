<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$days = isset($_POST['days']) ? floatval($_POST['days']) : 0.00;
$is_half_day = isset($_POST['is_half_day']) ? (int)$_POST['is_half_day'] : 0;
$half_day_type = $is_half_day && in_array($_POST['half_day_type'], ['first','second']) ? $_POST['half_day_type'] : NULL;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
$emergency_contact = isset($_POST['emergency_contact']) ? trim($_POST['emergency_contact']) : NULL;
$address_during_leave = isset($_POST['address_during_leave']) ? trim($_POST['address_during_leave']) : NULL;
$substitute_employee_id = isset($_POST['substitute_employee_id']) && !empty($_POST['substitute_employee_id']) ? (int)$_POST['substitute_employee_id'] : NULL;

if ($employee_id <= 0 || $type_id <= 0 || empty($start_date) || empty($end_date) || $days <= 0 || empty($reason)) {
    die("❌ Invalid request: Missing required fields");
}

$stmt = $conn->prepare("INSERT INTO leave_applications (
    employee_id, type_id, start_date, end_date, days, is_half_day, half_day_type,
    reason, emergency_contact, address_during_leave, substitute_employee_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissdsissss", 
    $employee_id, $type_id, $start_date, $end_date, $days, $is_half_day, $half_day_type,
    $reason, $emergency_contact, $address_during_leave, $substitute_employee_id
);

if ($stmt->execute()) {
    echo "✅ Leave applied successfully!";
} else {
    echo "❌ Failed to apply leave: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>