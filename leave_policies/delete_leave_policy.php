<?php
include 'db.php';

$policy_id = isset($_POST['policy_id']) ? (int)$_POST['policy_id'] : 0;

if ($policy_id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_policies WHERE policy_id = ?");
$stmt->bind_param("i", $policy_id);

if ($stmt->execute()) {
    echo "✅ Leave policy deleted successfully!";
} else {
    echo "❌ Failed to delete leave policy: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>