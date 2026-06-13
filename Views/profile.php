<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../Handlers/connection.php';
$user_id = $_SESSION['user_id'];

$success_message = $_SESSION['profile_success'] ?? "";
$error_message = $_SESSION['profile_error'] ?? "";
unset($_SESSION['profile_success'], $_SESSION['profile_error']);

// Get user data
try {
    $query = "SELECT user_name, user_email FROM users WHERE user_id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User record not found.");
    }
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Athenos</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <?php include_once 'header.php'; ?>

    <main class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <i class="fas fa-user-circle"></i>
                <h1>My Profile</h1>
                <p>Manage your account details</p>
            </div>
            
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <div class="profile-card">
                <div id="profile-view-state">
                    <div class="profile-info">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                <span>Username</span>
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($user['user_name']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                <span>Email Address</span>
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($user['user_email']); ?></div>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <button type="button" id="edit-profile-btn" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                    </div>
                </div>

                <form id="profile-edit-form" action="../Handlers/profile_handler.php" method="POST" style="display: none;">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" id="username" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <button type="button" id="cancel-edit-btn" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once 'footer.php'; ?>

    <script>
        const viewState = document.getElementById('profile-view-state');
        const editForm = document.getElementById('profile-edit-form');
        const editBtn = document.getElementById('edit-profile-btn');
        const cancelBtn = document.getElementById('cancel-edit-btn');

        editBtn.addEventListener('click', () => {
            viewState.style.display = 'none';
            editForm.style.display = 'block';
        });

        cancelBtn.addEventListener('click', () => {
            editForm.style.display = 'none';
            viewState.style.display = 'block';
        });
    </script>
</body>
</html>