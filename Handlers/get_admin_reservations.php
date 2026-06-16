<?php
session_start();
header('Content-Type: application/json');

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in output
ini_set('log_errors', 1);

// Check authentication
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Include database connection
require_once 'connection.php';

// Check if connection exists
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Handle POST requests (Update status or Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit();
    }
    
    // Handle Delete Action
    if (isset($input['action']) && $input['action'] === 'delete') {
        $reservation_id = isset($input['reservation_id']) ? intval($input['reservation_id']) : 0;
        
        if ($reservation_id <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid reservation ID']);
            exit();
        }
        
        $stmt = $conn->prepare("DELETE FROM reservation WHERE reservation_id = ?");
        $stmt->bind_param("i", $reservation_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Delete failed: ' . $stmt->error]);
        }
        $stmt->close();
        $conn->close();
        exit();
    }
    
    // Handle Status Update
    if (isset($input['reservation_id']) && isset($input['status'])) {
        $reservation_id = intval($input['reservation_id']);
        $status = $input['status'];
        
        // Validate status
        if (!in_array($status, ['confirmed', 'cancelled'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid status value']);
            exit();
        }
        
        $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ?");
        $stmt->bind_param("si", $status, $reservation_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Update failed: ' . $stmt->error]);
        }
        $stmt->close();
        $conn->close();
        exit();
    }
    
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
    exit();
}

// GET request - Fetch all reservations
// Since we don't know if 'locations' table exists, we'll check and handle it
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
    r.date_created
FROM reservation r
ORDER BY 
    CASE WHEN r.status = 'pending' THEN 0 ELSE 1 END,
    r.reservation_date DESC, 
    r.reservation_time ASC";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['success' => false, 'error' => 'Query failed: ' . $conn->error]);
    $conn->close();
    exit();
}

$reservations = [];
while ($row = $result->fetch_assoc()) {
    // Add location_name based on location_id or default
    $row['location_name'] = $row['location_id'] ? 'Location ' . $row['location_id'] : 'Unknown Location';
    $reservations[] = $row;
}

echo json_encode(['success' => true, 'data' => $reservations]);

$conn->close();
?>