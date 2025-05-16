<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$pay_date = isset($_POST['pay_date']) ? $_POST['pay_date'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'draft';
$created_by = isset($_POST['created_by']) && $_POST['created_by'] !== '' ? (int)$_POST['created_by'] : NULL;

if (empty($name) || empty($start_date) || empty($end_date) || empty($pay_date)) {
    die("❌ Invalid request: Missing required fields");
}

$stmt = $conn->prepare("INSERT INTO pay_periods (
    name, start_date, end_date, pay_date, status, created_by
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $name, $start_date, $end_date, $pay_date, $status, $created_by);

if ($stmt->execute()) {
    echo "✅ Pay period added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A pay period with this name already exists.";
    } else {
        echo "❌ Failed to add pay period: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>