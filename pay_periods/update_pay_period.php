<?php
include 'db.php';

$period_id = isset($_POST['period_id']) ? (int)$_POST['period_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$pay_date = isset($_POST['pay_date']) ? $_POST['pay_date'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'draft';

if ($period_id <= 0 || empty($name) || empty($start_date) || empty($end_date) || empty($pay_date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE pay_periods SET name = ?, start_date = ?, end_date = ?, pay_date = ?, status = ? WHERE period_id = ?");
$stmt->bind_param("sssssi", $name, $start_date, $end_date, $pay_date, $status, $period_id);

if ($stmt->execute()) {
    echo "✅ Pay period updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A pay period with this name already exists.";
    } else {
        echo "❌ Failed to update pay period: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>