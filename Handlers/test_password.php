<?php
require_once 'connection.php';

$email = 'admin@gmail.com';
$new_password = 'admin123';

// Generate new hash
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Update the password
$stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
$stmt->bind_param("ss", $new_hash, $email);

if ($stmt->execute()) {
    echo "<strong style='color:green'>✓ Password updated successfully!</strong><br>";
    echo "Email: " . $email . "<br>";
    echo "New Password: " . $new_password . "<br>";
    echo "New Hash: " . $new_hash . "<br>";
    
    // Verify it works
    $verify_stmt = $conn->prepare("SELECT user_password FROM users WHERE user_email = ?");
    $verify_stmt->bind_param("s", $email);
    $verify_stmt->execute();
    $result = $verify_stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (password_verify($new_password, $row['user_password'])) {
        echo "<br><strong style='color:green'>✓ Verification: Password works correctly!</strong>";
    } else {
        echo "<br><strong style='color:red'>✗ Verification failed!</strong>";
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>