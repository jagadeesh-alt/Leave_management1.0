<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$level = isset($_POST['level']) ? (int)$_POST['level'] : 1;
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';
$action_date = isset($_POST['action_date']) && !empty($_POST['action_date']) ? $_POST['action_date'] : NULL;

$allowedStatuses = ['pending','approved','rejected','delegated'];
if (!in_array($status, $allowedStatuses)) {
    die("❌ Invalid status selected");
}

if ($id <= 0 || $level <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_approval_workflow SET level = ?, status = ?, action_date = ? WHERE id = ?");
$stmt->bind_param("iisi", $level, $status, $action_date, $id);

if ($stmt->execute()) {
    echo "✅ Approval step updated successfully!";
} else {
    echo "❌ Failed to update approval step: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>