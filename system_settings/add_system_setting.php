<?php
include 'db.php';

$setting_key = isset($_POST['setting_key']) ? trim($_POST['setting_key']) : '';
$setting_value = isset($_POST['setting_value']) ? trim($_POST['setting_value']) : '';
$data_type = isset($_POST['data_type']) ? $_POST['data_type'] : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
$is_public = isset($_POST['is_public']) ? (int)$_POST['is_public'] : 0;
$updated_by = isset($_POST['updated_by']) && !empty($_POST['updated_by']) ? (int)$_POST['updated_by'] : NULL;

$allowedTypes = ['string','number','boolean','json','date'];
if (!in_array($data_type, $allowedTypes)) {
    die("❌ Invalid data type selected");
}

if (empty($setting_key) || empty($data_type)) {
    die("❌ Setting key and data type are required");
}

$stmt = $conn->prepare("INSERT INTO system_settings (
    setting_key, setting_value, data_type, description, is_public, updated_by
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssii", 
    $setting_key, $setting_value, $data_type, $description, $is_public, $updated_by
);

if ($stmt->execute()) {
    echo "✅ System setting added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A setting with this key already exists.";
    } else {
        echo "❌ Failed to add setting: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>