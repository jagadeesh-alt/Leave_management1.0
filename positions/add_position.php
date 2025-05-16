<?php
include 'db.php';

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : '';
$dept_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' ? (int)$_POST['department_id'] : NULL;
$career_level = isset($_POST['career_level']) ? $_POST['career_level'] : '';
$is_management = isset($_POST['is_management']) ? (int)$_POST['is_management'] : 0;

if (empty($title)) {
    die("❌ Position title is required");
}

$stmt = $conn->prepare("INSERT INTO positions (title, job_description, department_id, career_level, is_management) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $title, $desc, $dept_id, $career_level, $is_management);

if ($stmt->execute()) {
    echo "✅ Position added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A position with this title already exists.";
    } else {
        echo "❌ Failed to add position: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>