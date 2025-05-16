<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$period_id = isset($_POST['period_id']) ? (int)$_POST['period_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$application_id = isset($_POST['application_id']) && $_POST['application_id'] !== '' ? (int)$_POST['application_id'] : NULL;
$days = isset($_POST['days']) ? floatval($_POST['days']) : 0.00;
$impact_type = isset($_POST['impact_type']) ? $_POST['impact_type'] : '';
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;

$allowedTypes = ['deduction', 'addition'];
if (!in_array($impact_type, $allowedTypes)) {
    die("❌ Invalid impact type selected");
}

if ($employee_id <= 0 || $period_id <= 0 || $type_id <= 0 || empty($impact_type) || $days <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO leave_impact_on_payroll (
    employee_id, period_id, type_id, application_id, days, impact_type, amount
) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisdss", 
    $employee_id, $period_id, $type_id, $application_id, $days, $impact_type, $amount
);

if ($stmt->execute()) {
    echo "✅ Leave impact added successfully!";
} else {
    echo "❌ Failed to add impact: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>