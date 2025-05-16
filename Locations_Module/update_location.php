<?php
include 'db.php';

$location_id = isset($_POST['location_id']) ? (int)$_POST['location_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$city = isset($_POST['city']) ? trim($_POST['city']) : '';
$state = isset($_POST['state']) ? trim($_POST['state']) : '';
$country = isset($_POST['country']) ? trim($_POST['country']) : '';
$postal_code = isset($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

if ($location_id <= 0 || empty($name)) {
    die("❌ Invalid request");
}

$stmt = $conn->prepare("UPDATE locations SET name = ?, address = ?, city = ?, state = ?, country = ?, postal_code = ?, phone = ?, is_active = ? WHERE location_id = ?");
$stmt->bind_param("sssssssii", $name, $address, $city, $state, $country, $postal_code, $phone, $is_active, $location_id);

if ($stmt->execute()) {
    echo "✅ Location updated successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A location with this name already exists.";
    } else {
        echo "❌ Failed to update location: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>