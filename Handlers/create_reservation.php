<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Turn off error reporting for clean JSON output
error_reporting(0);
ini_set('display_errors', 0);

// Database connection
require_once 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required = ['location_id', 'customer_name', 'customer_email', 'customer_phone', 'reservation_date', 'reservation_time', 'party_size'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
        exit;
    }
}

// Convert time from 12-hour format to 24-hour format for database
$reservation_time = date("H:i:s", strtotime($data['reservation_time']));

// Insert reservation - store customer info directly in reservation table
$sql = "INSERT INTO reservation (customer_name, customer_email, customer_phone, location_id, reservation_date, reservation_time, party_size, status, date_created) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisis", 
    $data['customer_name'], 
    $data['customer_email'], 
    $data['customer_phone'], 
    $data['location_id'], 
    $data['reservation_date'], 
    $reservation_time, 
    $data['party_size']
);
$stmt->execute();
$reservation_id = $conn->insert_id;

if ($reservation_id) {
    echo json_encode(['success' => true, 'reservation_id' => $reservation_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to save reservation: ' . $conn->error]);
}

$conn->close();
?>