<?php
include 'db.php';

$employee_code = isset($_POST['employee_code']) ? trim($_POST['employee_code']) : '';
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$hire_date = isset($_POST['hire_date']) ? $_POST['hire_date'] : '';
$birth_date = isset($_POST['birth_date']) && !empty($_POST['birth_date']) ? $_POST['birth_date'] : NULL;
$gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
$marital_status = isset($_POST['marital_status']) ? $_POST['marital_status'] : NULL;
$employment_type = isset($_POST['employment_type']) ? $_POST['employment_type'] : NULL;
$job_title = isset($_POST['job_title']) ? trim($_POST['job_title']) : NULL;
$department_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' ? (int)$_POST['department_id'] : NULL;
$location_id = isset($_POST['location_id']) && $_POST['location_id'] !== '' ? (int)$_POST['location_id'] : NULL;
$status = isset($_POST['status']) ? $_POST['status'] : 'active';
$termination_date = isset($_POST['termination_date']) && !empty($_POST['termination_date']) ? $_POST['termination_date'] : NULL;
$termination_reason = isset($_POST['termination_reason']) ? trim($_POST['termination_reason']) : NULL;

if (empty($employee_code) || empty($first_name) || empty($last_name) || empty($email) || empty($hire_date)) {
    die("❌ Required fields are missing");
}

$stmt = $conn->prepare("INSERT INTO employees (
    employee_code, first_name, last_name, email, phone, hire_date, birth_date, gender, marital_status,
    employment_type, job_title, department_id, location_id, status, termination_date, termination_reason
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssssssssss", 
    $employee_code, $first_name, $last_name, $email, $phone, $hire_date, $birth_date, $gender, $marital_status,
    $employment_type, $job_title, $department_id, $location_id, $status, $termination_date, $termination_reason
);

if ($stmt->execute()) {
    echo "✅ Employee added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ An employee with this code or email already exists.";
    } else {
        echo "❌ Failed to add employee: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>