<?php
include 'db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

if ($id <= 0 || empty($name) || empty($start_date) || empty($end_date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE leave_blackout_periods SET name = ?, start_date = ?, end_date = ?, is_active = ? WHERE id = ?");
$stmt->bind_param("sssii", $name, $start_date, $end_date, $is_active, $id);

if ($stmt->execute()) {
    echo "✅ Blackout period updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A blackout period with this name already exists.";
    } else {
        echo "❌ Failed to update blackout period: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>