<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$effective_date = isset($_POST['effective_date']) ? $_POST['effective_date'] : '';
$created_by = isset($_POST['created_by']) && !empty($_POST['created_by']) ? (int)$_POST['created_by'] : NULL;
$is_default = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

if (empty($name) || empty($effective_date)) {
    die("❌ Name and Effective Date are required");
}

$stmt = $conn->prepare("INSERT INTO leave_policies (name, description, effective_date, is_default, created_by) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $name, $description, $effective_date, $is_default, $created_by);

if ($stmt->execute()) {
    echo "✅ Leave policy added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A leave policy with this name already exists.";
    } else {
        echo "❌ Failed to add leave policy: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>