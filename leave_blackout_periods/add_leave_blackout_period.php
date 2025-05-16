<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$type_id = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : NULL;
$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
$created_by = isset($_POST['created_by']) && $_POST['created_by'] !== '' ? (int)$_POST['created_by'] : NULL;

if (empty($name) || empty($start_date) || empty($end_date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("INSERT INTO leave_blackout_periods (
    name, start_date, end_date, type_id, description, is_active, created_by
) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiii", $name, $start_date, $end_date, $type_id, $description, $is_active, $created_by);

if ($stmt->execute()) {
    echo "✅ Blackout period added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A blackout period with this name already exists.";
    } else {
        echo "❌ Failed to add blackout period: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>