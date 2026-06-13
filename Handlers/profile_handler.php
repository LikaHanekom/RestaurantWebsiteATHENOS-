<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/login.php");
    exit();
}

require_once 'connection.php'; 

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['user_name']);
    $new_email = trim($_POST['user_email']);

    if (empty($new_username) || empty($new_email)) {
        $_SESSION['profile_error'] = "Username and Email are required.";
    } else {
        $update_query = "UPDATE users SET user_name = ?, user_email = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ssi', $new_username, $new_email, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['profile_success'] = "Profile updated successfully!";
        } else {
            $_SESSION['profile_error'] = "Failed to update profile.";
        }
    }
}
header("Location: ../Views/profile.php");
exit();