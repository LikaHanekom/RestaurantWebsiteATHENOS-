<?php
// api/get_locations.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');


// Database connection - Fix special character in password
require_once 'connection.php';

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Query to get all active locations
$sql = "SELECT 
            location_id,
            location_name,
            province,
            address,
            phone,
            email,
            features,
            capacity,
            is_active
        FROM locations 
        WHERE is_active = 1 
        ORDER BY province, location_name";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    $conn->close();
    exit;
}

$locations = [];
while ($row = $result->fetch_assoc()) {
    // Decode JSON features if they exist
    if ($row['features']) {
        $row['features'] = json_decode($row['features'], true);
    } else {
        $row['features'] = [];
    }
    
    // Add to locations array
    $locations[] = $row;
}

// Return JSON response
echo json_encode($locations);

$conn->close();
?>