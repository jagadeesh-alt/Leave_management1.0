<?php
include 'db.php';

$application_id = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
$approver_id = isset($_POST['approver_id']) ? (int)$_POST['approver_id'] : 0;
$level = isset($_POST['level']) ? (int)$_POST['level'] : 1;
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';
$comments = isset($_POST['comments']) ? trim($_POST['comments']) : NULL;
$delegated_to = isset($_POST['delegated_to']) && !empty($_POST['delegated_to']) ? (int)$_POST['delegated_to'] : NULL;
$action_date = isset($_POST['action_date']) && !empty($_POST['action_date']) ? $_POST['action_date'] : NULL;

$allowedStatuses = ['pending','approved','rejected','delegated'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($application_id <= 0 || $approver_id <= 0 || $level <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO leave_approval_workflow (
    application_id, approver_id, level, status, comments, delegated_to, action_date
) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiissis", 
    $application_id, $approver_id, $level, $status, $comments, $delegated_to, $action_date
);

if ($stmt->execute()) {
    echo "✅ Approval step added successfully!";
} else {
    echo "❌ Failed to add approval step: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>