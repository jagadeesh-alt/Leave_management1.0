<?php
include 'db.php';

// Get POST data with validation
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$desc = isset($_POST['description']) ? trim($_POST['description']) : '';
$is_system = isset($_POST['is_system']) ? (int)$_POST['is_system'] : 0;

// Validate required fields
if ($role_id <= 0 || empty($name)) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'message' => '❌ Invalid request']));
}

// Prepare and execute the statement
$stmt = $conn->prepare("UPDATE roles SET name = ?, description = ?, is_system = ? WHERE role_id = ?");
$stmt->bind_param("ssii", $name, $desc, $is_system, $role_id);

header('Content-Type: application/json');

if ($stmt->execute()) {
    // Get updated counts
    $totalResult = $conn->query("SELECT COUNT(*) as total FROM roles");
    $totalRow = $totalResult->fetch_assoc();
    
    $systemResult = $conn->query("SELECT COUNT(*) as total FROM roles WHERE is_system = 1");
    $systemRow = $systemResult->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'message' => '✅ Role updated successfully!',
        'totalCount' => $totalRow['total'],
        'systemCount' => $systemRow['total']
    ]);
} else {
    // Check for duplicate entry error
    if ($conn->errno == 1062) {
        echo json_encode(['success' => false, 'message' => '❌ Role with this name already exists']);
    } else {
        echo json_encode(['success' => false, 'message' => '❌ Failed to update role: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>