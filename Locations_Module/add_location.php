<?php
include 'db.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$city = isset($_POST['city']) ? trim($_POST['city']) : '';
$state = isset($_POST['state']) ? trim($_POST['state']) : '';
$country = isset($_POST['country']) ? trim($_POST['country']) : '';
$postal_code = isset($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

if (empty($name)) {
    die("❌ Location name is required");
}

$stmt = $conn->prepare("INSERT INTO locations (name, address, city, state, country, postal_code, phone, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $name, $address, $city, $state, $country, $postal_code, $phone, $is_active);

if ($stmt->execute()) {
    echo "✅ Location added successfully!";
} else {
    if ($conn->errno == 1062) {
        echo "❌ A location with this name already exists.";
    } else {
        echo "❌ Failed to add location: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>