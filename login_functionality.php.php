<?php

session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log to see if script is running
file_put_contents('debug_log.txt', "Script started at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

$conn = new mysqli("localhost", "root", "Lovetennis@16", "restaurant");

if ($conn->connect_error) {
    file_put_contents('debug_log.txt', "DB Connection failed: " . $conn->connect_error . "\n", FILE_APPEND);
    die("Connection failed");
}

file_put_contents('debug_log.txt', "DB Connected successfully\n", FILE_APPEND);

// Check if POST data is received
if(empty($_POST)) {
    file_put_contents('debug_log.txt', "No POST data received\n", FILE_APPEND);
    echo "NO_POST_DATA";
    exit();
}

file_put_contents('debug_log.txt', "POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);

$email = trim($_POST['email']);
$password = $_POST['password'];

file_put_contents('debug_log.txt', "Email: $email\n", FILE_APPEND);

$sql = "SELECT * FROM users WHERE TRIM(user_email) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

file_put_contents('debug_log.txt', "Number of rows found: " . $result->num_rows . "\n", FILE_APPEND);

if ($result->num_rows == 0) {
    file_put_contents('debug_log.txt', "Email not found in database\n", FILE_APPEND);
    echo "EMAIL_NOT_FOUND";
    exit();
}

$user = $result->fetch_assoc();
file_put_contents('debug_log.txt', "User found: " . print_r($user, true) . "\n", FILE_APPEND);

// Check password verification
$password_verify_result = password_verify($password, $user['user_password']);
file_put_contents('debug_log.txt', "Password verify result: " . ($password_verify_result ? "true" : "false") . "\n", FILE_APPEND);

if ($password_verify_result) {
    $_SESSION['user_id'] = $user['user_id'];
    file_put_contents('debug_log.txt', "Login successful for user_id: " . $user['user_id'] . "\n", FILE_APPEND);
    echo "success";
    exit();
} else {
    file_put_contents('debug_log.txt', "Password verification failed\n", FILE_APPEND);
    echo "INVALID_PASSWORD";
    exit();
}

echo "UNKNOWN_ERROR";

?>

php
<?php
$conn = new mysqli("localhost", "root", "Lovetennis@16", "restaurant");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, user_email, user_password FROM users";
$result = $conn->query($sql);

echo "<pre>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['user_id'] . "\n";
        echo "Email: " . $row['user_email'] . "\n";
        echo "Password Hash: " . $row['user_password'] . "\n";
        echo "---\n";
    }
} else {
    echo "No users found in database\n";
}
echo "</pre>";

$conn->close();
?>

<?php
// test_password.php
$conn = new mysqli("localhost", "root", "Lovetennis@16", "restaurant");

$email = "your_email@example.com"; // Change this to a real email
$test_password = "your_password"; // Change this to the password you want to test

$sql = "SELECT user_password FROM users WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($test_password, $row['user_password'])) {
        echo "Password is correct!";
    } else {
        echo "Password is incorrect!";
        echo "\nHash in DB: " . $row['user_password'];
    }
} else {
    echo "Email not found";
}
?>