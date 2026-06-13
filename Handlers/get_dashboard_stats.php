<?php
session_start();
header('Content-Type: application/json');

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit();
}

require_once 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$today = date('Y-m-d');
$stats = [];

// Today's reservations
$result = $conn->query("SELECT COUNT(*) as count FROM reservation WHERE reservation_date = '$today'");
$stats['today_reservations'] = $result ? $result->fetch_assoc()['count'] : 0;

// Pending reservations
$result = $conn->query("SELECT COUNT(*) as count FROM reservation WHERE status = 'pending'");
$stats['pending_reservations'] = $result ? $result->fetch_assoc()['count'] : 0;

// Total users count
$result = $conn->query("SELECT COUNT(*) as count FROM users");
$stats['total_users'] = $result ? $result->fetch_assoc()['count'] : 0;

$conn->close();

echo json_encode(['success' => true, 'data' => $stats]);
?>