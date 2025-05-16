<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$code = isset($_POST['code']) ? strtoupper(trim($_POST['code'])) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$category = isset($_POST['category']) ? $_POST['category'] : NULL;
$is_paid = isset($_POST['is_paid']) ? (int)$_POST['is_paid'] : 1;
$requires_approval = isset($_POST['requires_approval']) ? (int)$_POST['requires_approval'] : 1;
$min_notice_days = isset($_POST['min_notice_days']) ? (int)$_POST['min_notice_days'] : 1;
$max_consecutive_days = isset($_POST['max_consecutive_days']) && $_POST['max_consecutive_days'] > 0 ? (int)$_POST['max_consecutive_days'] : NULL;
$max_days_per_request = isset($_POST['max_days_per_request']) && $_POST['max_days_per_request'] > 0 ? (int)$_POST['max_days_per_request'] : NULL;
$max_days_per_year = isset($_POST['max_days_per_year']) && $_POST['max_days_per_year'] > 0 ? (int)$_POST['max_days_per_year'] : NULL;
$allow_half_day = isset($_POST['allow_half_day']) ? (int)$_POST['allow_half_day'] : 0;
$carry_forward = isset($_POST['carry_forward']) ? (int)$_POST['carry_forward'] : 0;
$carry_forward_limit = isset($_POST['carry_forward_limit']) && $_POST['carry_forward_limit'] > 0 ? (int)$_POST['carry_forward_limit'] : NULL;
$carry_forward_expiry_months = isset($_POST['carry_forward_expiry_months']) && $_POST['carry_forward_expiry_months'] > 0 ? (int)$_POST['carry_forward_expiry_months'] : NULL;
$gender_specific = isset($_POST['gender_specific']) ? $_POST['gender_specific'] : 'none';
$tenure_restriction_days = isset($_POST['tenure_restriction_days']) ? (int)$_POST['tenure_restriction_days'] : 0;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

if (empty($name) || empty($code)) {
    die("❌ Name and code are required");
}

$stmt = $conn->prepare("INSERT INTO leave_types (
    name, code, description, category, is_paid, requires_approval,
    min_notice_days, max_consecutive_days, max_days_per_request,
    max_days_per_year, allow_half_day, carry_forward, carry_forward_limit,
    carry_forward_expiry_months, gender_specific, tenure_restriction_days, is_active
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssiisiiiiiisii",
    $name, $code, $description, $category, $is_paid, $requires_approval,
    $min_notice_days, $max_consecutive_days, $max_days_per_request,
    $max_days_per_year, $allow_half_day, $carry_forward, $carry_forward_limit,
    $carry_forward_expiry_months, $gender_specific, $tenure_restriction_days, $is_active
);

if ($stmt->execute()) {
    echo "✅ Leave type added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A leave type with this code already exists.";
    } else {
        echo "❌ Failed to add leave type: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>