<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

require_once 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$sql = "SELECT 
    r.reservation_id,
    r.customer_name,
    r.customer_email,
    r.customer_phone,
    r.location_id,
    r.reservation_date,
    r.reservation_time,
    r.party_size,
    r.status,
    r.date_created,
    l.location_name
FROM reservation r
LEFT JOIN locations l ON r.location_id = l.location_id
ORDER BY 
    CASE WHEN r.status = 'pending' THEN 0 ELSE 1 END,
    r.reservation_date DESC, 
    r.reservation_time ASC";

$result = $conn->query($sql);
$reservations = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $reservations]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to fetch reservations: ' . $conn->error]);
}

$conn->close();
?>