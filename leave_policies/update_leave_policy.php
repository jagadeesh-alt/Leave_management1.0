<?php
include 'db.php';

$policy_id = isset($_POST['policy_id']) ? (int)$_POST['policy_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$effective_date = isset($_POST['effective_date']) ? $_POST['effective_date'] : '';
$is_default = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

if ($policy_id <= 0 || empty($name) || empty($effective_date)) {
    die("❌ Invalid request");
}

// Reset other policies if this becomes default
if ($is_default) {
    $conn->query("UPDATE leave_policies SET is_default = 0 WHERE policy_id != $policy_id");
}

$stmt = $conn->prepare("UPDATE leave_policies SET name = ?, description = ?, effective_date = ?, is_default = ? WHERE policy_id = ?");
$stmt->bind_param("sssii", $name, $description, $effective_date, $is_default, $policy_id);

if ($stmt->execute()) {
    echo "✅ Leave policy updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A leave policy with this name already exists.";
    } else {
        echo "❌ Failed to update leave policy: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>