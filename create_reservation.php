<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$host = 'localhost';
$username = 'root';
$password = 'Lovetennis@16';
$database = 'restaurant';

$conn = new mysqli($host, $username, $password, $database);

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

// Get location details for email
$locationQuery = "SELECT location_name, email as location_email FROM locations WHERE location_id = ?";
$stmt = $conn->prepare($locationQuery);
$stmt->bind_param("i", $data['location_id']);
$stmt->execute();
$location = $stmt->get_result()->fetch_assoc();

if (!$location) {
    echo json_encode(['success' => false, 'error' => 'Invalid location']);
    exit;
}

$data['reservation_time'] = date("H:i:s", strtotime($data['reservation_time']));
// Insert reservation (Removed user_id constraint to prevent NOT NULL database exceptions)
$sql = "INSERT INTO reservation (location_id, reservation_date, reservation_time, party_size, status, date_created) 
        VALUES (?, ?, ?, ?, 'pending', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $data['location_id'], $data['reservation_date'], $data['reservation_time'], $data['party_size']);
$stmt->execute();
$reservation_id = $conn->insert_id;

if ($reservation_id) {
    // Send confirmation email to customer (@ suppression prevents local SMTP configuration crashes)
    $customer_subject = "Athenos - Reservation Confirmation";
    $customer_message = "
    <html>
    <body>
        <h2>Thank you for your reservation, {$data['customer_name']}!</h2>
        <p><strong>Location:</strong> {$location['location_name']}</p>
        <p><strong>Date:</strong> {$data['reservation_date']}</p>
        <p><strong>Time:</strong> {$data['reservation_time']}</p>
        <p><strong>Guests:</strong> {$data['party_size']}</p>
        <p><strong>Status:</strong> Pending Confirmation</p>
        <p>We'll send you a confirmation email once your booking is confirmed.</p>
        <br>
        <p>Warm regards,<br>Athenos Greek Taverna</p>
    </body>
    </html>
    ";
    
    @mail($data['customer_email'], $customer_subject, $customer_message, "Content-Type: text/html; charset=UTF-8");
    
    // Send notification to location admin
    $admin_subject = "New Reservation at {$location['location_name']}";
    $admin_message = "
    <html>
    <body>
        <h2>New Reservation Received</h2>
        <p><strong>Customer:</strong> {$data['customer_name']}</p>
        <p><strong>Email:</strong> {$data['customer_email']}</p>
        <p><strong>Phone:</strong> {$data['customer_phone']}</p>
        <p><strong>Date:</strong> {$data['reservation_date']}</p>
        <p><strong>Time:</strong> {$data['reservation_time']}</p>
        <p><strong>Guests:</strong> {$data['party_size']}</p>
        <p><strong>Special Requests:</strong> " . ($data['special_requests'] ?? 'None') . "</p>
    </body>
    </html>
    ";
    
    @mail($location['location_email'], $admin_subject, $admin_message, "Content-Type: text/html; charset=UTF-8");
    
    echo json_encode(['success' => true, 'reservation_id' => $reservation_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to save reservation']);
}

$conn->close();
?>