<?php
include 'db.php';

$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$code = isset($_POST['code']) ? strtoupper(trim($_POST['code'])) : '';
$category = isset($_POST['category']) ? $_POST['category'] : NULL;
$is_paid = isset($_POST['is_paid']) ? (int)$_POST['is_paid'] : 1;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

if ($type_id <= 0 || empty($name) || empty($code)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_types SET name = ?, code = ?, category = ?, is_paid = ?, is_active = ? WHERE type_id = ?");
$stmt->bind_param("sssiii", $name, $code, $category, $is_paid, $is_active, $type_id);

if ($stmt->execute()) {
    echo "✅ Leave type updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A leave type with this code already exists.";
    } else {
        echo "❌ Failed to update leave type: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>