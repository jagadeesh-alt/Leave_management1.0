<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("❌ Invalid request method");
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die("❌ No file uploaded or invalid file");
}

$application_id = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
$uploader_id = isset($_POST['uploaded_by']) ? (int)$_POST['uploaded_by'] : 0;

if ($application_id <= 0 || $uploader_id <= 0) {
    die("❌ Invalid request: Missing required fields");
}

$file_name = basename($_FILES["file"]["name"]);
$file_tmp = $_FILES["file"]["tmp_name"];
$file_type = mime_content_type($file_tmp);
$file_size = $_FILES["file"]["size"];
$file_path = "uploads/leave/" . uniqid() . "_" . $file_name;

// Create uploads directory if not exists
$targetDir = "uploads/leave/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (move_uploaded_file($file_tmp, $file_path)) {
    $stmt = $conn->prepare("INSERT INTO leave_attachments (
        application_id, file_name, file_path, file_type, file_size, uploaded_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiii", 
        $application_id, $file_name, $file_path, $file_type, $file_size, $uploader_id
    );

    if ($stmt->execute()) {
        echo "✅ File uploaded successfully!";
    } else {
        unlink($file_path); // Rollback file if DB insert fails
        echo "❌ Failed to save file metadata: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ File upload failed.";
}

$conn->close();
?>