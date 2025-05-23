<?php
include 'db.php';

header('Content-Type: application/json');

// Get total role count
$result = $conn->query("SELECT COUNT(*) as total FROM roles");
$totalRow = $result->fetch_assoc();

// Get system role count
$result = $conn->query("SELECT COUNT(*) as total FROM roles WHERE is_system = 1");
$systemRow = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'totalCount' => $totalRow['total'],
    'systemCount' => $systemRow['total']
]);

$conn->close();
?>