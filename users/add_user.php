<?php
include 'db.php';

$employee_id = isset($_POST['employee_id']) && $_POST['employee_id'] !== '' ? (int)$_POST['employee_id'] : NULL;
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password_hash = isset($_POST['password_hash']) ? password_hash(trim($_POST['password_hash']), PASSWORD_DEFAULT) : '';
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
$must_change_password = isset($_POST['must_change_password']) ? (int)$_POST['must_change_password'] : 1;
$account_locked = isset($_POST['account_locked']) ? (int)$_POST['account_locked'] : 0;

if (empty($username) || empty($email) || empty($password_hash) || $role_id <= 0) {
    die("❌ Invalid request: Missing required fields");
}

$stmt = $conn->prepare("INSERT INTO users (
    employee_id, username, email, password_hash, role_id,
    must_change_password, account_locked
) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiii", 
    $employee_id, $username, $email, $password_hash, $role_id, $must_change_password, $account_locked
);

if ($stmt->execute()) {
    echo "✅ User added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A user with this username or email already exists.";
    } else {
        echo "❌ Failed to add user: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>