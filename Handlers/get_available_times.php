<?php
header('Content-Type: application/json');

require_once 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Get parameters
$location_id = isset($_GET['location_id']) ? (int)$_GET['location_id'] : 0;
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$location_id || !$date) {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    $conn->close();
    exit();
}

// All possible time slots in 24-hour format
$allTimeSlots24 = [
    '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00',
    '14:30:00', '17:00:00', '17:30:00', '18:00:00', '18:30:00',
    '19:00:00', '19:30:00', '20:00:00', '20:30:00', '21:00:00'
];

// All possible time slots in 12-hour format for display
$allTimeSlots12 = [
    '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM',
    '02:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM',
    '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM'
];

// Get booked times from database
$sql = "SELECT reservation_time FROM reservation 
        WHERE location_id = ? 
        AND reservation_date = ? 
        AND status IN ('pending', 'confirmed')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $location_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$bookedTimes24 = [];
while ($row = $result->fetch_assoc()) {
    $bookedTimes24[] = $row['reservation_time'];
}
$stmt->close();

// Find available times
$availableTimes = [];
for ($i = 0; $i < count($allTimeSlots24); $i++) {
    if (!in_array($allTimeSlots24[$i], $bookedTimes24)) {
        $availableTimes[] = $allTimeSlots12[$i];
    }
}

echo json_encode(['success' => true, 'available_times' => $availableTimes]);
$conn->close();
?>