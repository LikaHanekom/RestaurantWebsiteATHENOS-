<?php //backend page managing admin reservations
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$username = 'root';
$password = 'Lovetennis@16';
$database = 'restaurant';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Handle Status Updates (POST requests)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!empty($data['reservation_id']) && !empty($data['status'])) {
        $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ?");
        $stmt->bind_param("si", $data['status'], $data['reservation_id']);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update reservation status']);
        }
        $stmt->close();
        $conn->close();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    // DELETE RESERVATION
    if (!empty($data['action']) && $data['action'] === 'delete') {

        $stmt = $conn->prepare("DELETE FROM reservation WHERE reservation_id = ?");
        $stmt->bind_param("i", $data['reservation_id']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Delete failed']);
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    // UPDATE STATUS (existing code)
    if (!empty($data['reservation_id']) && !empty($data['status'])) {

        $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ?");
        $stmt->bind_param("si", $data['status'], $data['reservation_id']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Update failed']);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
}

// Handle Fetching Data (GET requests)
// Added alternative selections to support schemas where customer details are stored directly in the table
$sql = "SELECT 
    r.reservation_id,
    r.reservation_date,
    r.reservation_time,
    r.party_size,
    r.status,
    r.date_created,
    l.location_name,
    u.user_name AS customer_name,
    u.user_email AS customer_email
FROM reservation r
JOIN locations l ON r.location_id = l.location_id
LEFT JOIN users u ON r.user_id = u.user_id
ORDER BY r.reservation_date DESC, r.reservation_time DESC";

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