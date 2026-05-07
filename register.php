<?php
$conn = new mysqli("localhost", "root", "Lovetennis@16", "restaurant");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// validation
if (empty($name) || empty($surname) || empty($email) || empty($password)) {
    echo "All fields are required";
    exit();
}

// check password match (backend security)
if ($password !== $confirmPassword) {
    echo "Passwords do not match";
    exit();
}

// check email exists
$sql = "SELECT * FROM users WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Email already exists";
    exit();
}

// hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// force role
$role = "customer";

// insert
$sql = "INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Registration successful";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>