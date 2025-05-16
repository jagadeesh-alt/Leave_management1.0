<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$year = isset($_POST['year']) ? intval($_POST['year']) : 0;
$total_allocated = isset($_POST['total_allocated']) ? floatval($_POST['total_allocated']) : 0.00;
$total_used = isset($_POST['total_used']) ? floatval($_POST['total_used']) : 0.00;
$carried_forward = isset($_POST['carried_forward']) ? floatval($_POST['carried_forward']) : 0.00;
$pending_approval = isset($_POST['pending_approval']) ? floatval($_POST['pending_approval']) : 0.00;
$encashed = isset($_POST['encashed']) ? floatval($_POST['encashed']) : 0.00;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : NULL;

if ($employee_id <= 0 || $type_id <= 0 || $year <= 1900 || $total_allocated <= 0) {
    die("❌ Invalid request: Missing or incorrect data");
}

$stmt = $conn->prepare("INSERT INTO employee_leave_balances (
    employee_id, type_id, year, total_allocated, total_used,
    carried_forward, pending_approval, encashed, notes
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiddddds",
    $employee_id, $type_id, $year, $total_allocated, $total_used,
    $carried_forward, $pending_approval, $encashed, $notes
);

if ($stmt->execute()) {
    echo "✅ Leave balance added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A balance for this employee, type, and year already exists.";
    } else {
        echo "❌ Failed to add balance: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>