<?php
include 'db.php';

$rule_id = isset($_POST['rule_id']) ? (int)$_POST['rule_id'] : 0;

if ($rule_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_policy_rules WHERE rule_id = ?");
$stmt->bind_param("i", $rule_id);

if ($stmt->execute()) {
    echo "✅ Rule deleted successfully!";
} else {
    echo "❌ Failed to delete rule: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>