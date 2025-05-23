<?php
include 'db.php';

// Get POST data with validation
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

// Validate required fields
if ($role_id <= 0) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'message' => '❌ Invalid request']));
}

// First check if it exists
$checkResult = $conn->query("SELECT role_id FROM roles WHERE role_id = $role_id");
if ($checkResult->num_rows === 0) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'message' => '❌ Role not found']));
}

// Prepare and execute the statement
$stmt = $conn->prepare("DELETE FROM roles WHERE role_id = ?");
$stmt->bind_param("i", $role_id);

// Set header for JSON response
header('Content-Type: application/json');

if ($stmt->execute()) {
    // Get updated counts
    $totalResult = $conn->query("SELECT COUNT(*) as total FROM roles");
    $totalRow = $totalResult->fetch_assoc();
    
    $systemResult = $conn->query("SELECT COUNT(*) as total FROM roles WHERE is_system = 1");
    $systemRow = $systemResult->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'message' => '✅ Role deleted successfully!',
        'totalCount' => $totalRow['total'],
        'systemCount' => $systemRow['total']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => '❌ Failed to delete role: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>