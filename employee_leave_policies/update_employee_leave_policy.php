<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$effective_from = isset($_POST['effective_from']) ? $_POST['effective_from'] : '';
$effective_to = isset($_POST['effective_to']) && $_POST['effective_to'] !== '' ? $_POST['effective_to'] : NULL;

if ($id <= 0 || empty($effective_from)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE employee_leave_policies SET effective_from = ?, effective_to = ? WHERE id = ?");
$stmt->bind_param("ssi", $effective_from, $effective_to, $id);

if ($stmt->execute()) {
    echo "✅ Policy assignment updated successfully!";
} else {
    echo "❌ Failed to update: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>