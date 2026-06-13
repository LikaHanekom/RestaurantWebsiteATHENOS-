<?php
session_start();
header('Content-Type: application/json');

// Enable error reporting for debugging (disable on live)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';

// Check if POST data is received
if(empty($_POST)) {
    echo json_encode(['status' => 'error', 'code' => 'NO_POST_DATA', 'message' => 'No data received']);
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Select user_role as well
$sql = "SELECT user_id, user_name, user_email, user_password, user_role FROM users WHERE TRIM(user_email) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(['status' => 'error', 'code' => 'EMAIL_NOT_FOUND', 'message' => 'Email not found']);
    exit();
}

$user = $result->fetch_assoc();

// Check password verification
$password_verify_result = password_verify($password, $user['user_password']);

if ($password_verify_result) {
    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['user_email'] = $user['user_email'];
    $_SESSION['user_role'] = $user['user_role'];
    
    echo json_encode([
        'status' => 'success',
        'role' => $user['user_role']
    ]);
    exit();
} else {
    echo json_encode(['status' => 'error', 'code' => 'INVALID_PASSWORD', 'message' => 'Invalid password']);
    exit();
}
?>