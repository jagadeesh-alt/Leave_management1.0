<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$policy_id = isset($_POST['policy_id']) ? (int)$_POST['policy_id'] : 0;
$effective_from = isset($_POST['effective_from']) ? $_POST['effective_from'] : '';
$effective_to = isset($_POST['effective_to']) && $_POST['effective_to'] !== '' ? $_POST['effective_to'] : NULL;
$assigned_by = isset($_POST['assigned_by']) && $_POST['assigned_by'] !== '' ? (int)$_POST['assigned_by'] : NULL;

if ($employee_id <= 0 || $policy_id <= 0 || empty($effective_from)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO employee_leave_policies (
    employee_id, policy_id, effective_from, effective_to, assigned_by
) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $employee_id, $policy_id, $effective_from, $effective_to, $assigned_by);

if ($stmt->execute()) {
    echo "✅ Policy assigned successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ This policy is already assigned for the selected period.";
    } else {
        echo "❌ Failed to assign policy: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>