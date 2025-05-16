<?php
include 'db.php';

$position_id = isset($_POST['position_id']) ? (int)$_POST['position_id'] : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : '';
$dept_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' ? (int)$_POST['department_id'] : NULL;
$career_level = isset($_POST['career_level']) ? $_POST['career_level'] : '';
$is_management = isset($_POST['is_management']) ? (int)$_POST['is_management'] : 0;

if ($position_id <= 0 || empty($title)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE positions SET title = ?, job_description = ?, department_id = ?, career_level = ?, is_management = ? WHERE position_id = ?");
$stmt->bind_param("sssiis", $title, $desc, $dept_id, $career_level, $is_management, $position_id);

if ($stmt->execute()) {
    echo "✅ Position updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A position with this title already exists.";
    } else {
        echo "❌ Failed to update position: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>