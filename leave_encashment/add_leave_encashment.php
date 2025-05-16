<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$period_id = isset($_POST['period_id']) ? (int)$_POST['period_id'] : 0;
$days_encashed = isset($_POST['days_encashed']) ? floatval($_POST['days_encashed']) : 0.00;
$rate = isset($_POST['rate']) ? floatval($_POST['rate']) : 0.00;
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : ($days_encashed * $rate);
$request_date = isset($_POST['request_date']) ? $_POST['request_date'] : '';
$processed_date = isset($_POST['processed_date']) && !empty($_POST['processed_date']) ? $_POST['processed_date'] : NULL;
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';
$approved_by = isset($_POST['approved_by']) && !empty($_POST['approved_by']) ? (int)$_POST['approved_by'] : NULL;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : NULL;

$allowedStatuses = ['pending','approved','rejected','processed'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($employee_id <= 0 || $type_id <= 0 || $period_id <= 0 || empty($request_date) || $days_encashed <= 0 || $rate <= 0) {
    die("❌ Invalid request: Missing required fields");
}

$stmt = $conn->prepare("INSERT INTO leave_encashment (
    employee_id, type_id, period_id, days_encashed, rate, amount,
    request_date, processed_date, status, approved_by, notes
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiddssssis", 
    $employee_id, $type_id, $period_id, $days_encashed, $rate, $amount,
    $request_date, $processed_date, $status, $approved_by, $notes
);

if ($stmt->execute()) {
    echo "✅ Encashment added successfully!";
} else {
    echo "❌ Failed to add encashment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>