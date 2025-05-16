<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("DELETE FROM leave_impact_on_payroll WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Leave impact deleted successfully!";
} else {
    echo "❌ Failed to delete impact: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>