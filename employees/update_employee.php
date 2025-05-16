<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) ? (int)$_POST['employee_id'] : 0;
$employee_code = isset($_POST['employee_code']) ? trim($_POST['employee_code']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'active';
$hire_date = isset($_POST['hire_date']) ? $_POST['hire_date'] : '';

if ($employee_id <= 0 || empty($employee_code) || empty($email) || empty($hire_date)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE employees SET employee_code = ?, email = ?, status = ?, hire_date = ? WHERE employee_id = ?");
$stmt->bind_param("sssii", $employee_code, $email, $status, $hire_date, $employee_id);

if ($stmt->execute()) {
    echo "✅ Employee updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ An employee with this code or email already exists.";
    } else {
        echo "❌ Failed to update employee: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>