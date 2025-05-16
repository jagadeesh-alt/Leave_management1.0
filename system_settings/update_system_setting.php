<?php
include 'db.php';

$setting_id = isset($_POST['setting_id']) ? (int)$_POST['setting_id'] : 0;
$setting_key = isset($_POST['setting_key']) ? trim($_POST['setting_key']) : '';
$setting_value = isset($_POST['setting_value']) ? trim($_POST['setting_value']) : '';
$data_type = isset($_POST['data_type']) ? $_POST['data_type'] : '';
$is_public = isset($_POST['is_public']) ? (int)$_POST['is_public'] : 0;

$allowedTypes = ['string','number','boolean','json','date'];
if (!in_array($data_type, $allowedTypes)) {
    die("❌ Invalid data type selected");
}

if ($setting_id <= 0 || empty($setting_key) || empty($data_type)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE system_settings SET setting_key = ?, setting_value = ?, data_type = ?, is_public = ? WHERE setting_id = ?");
$stmt->bind_param("ssiii", $setting_key, $setting_value, $data_type, $is_public, $setting_id);

if ($stmt->execute()) {
    echo "✅ System setting updated successfully!";
} else {
    echo "❌ Failed to update setting: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>