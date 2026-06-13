<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos - Contact Us</title>
    <link rel="stylesheet" href="../CSS/contactUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<?php
session_start();

// Include PHPMailer files
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message_sent = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $firstName = htmlspecialchars(strip_tags(trim($_POST['firstName'])));
    $lastName = htmlspecialchars(strip_tags(trim($_POST['lastName'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile = htmlspecialchars(strip_tags(trim($_POST['mobileNumber'])));
    $queryType = htmlspecialchars(strip_tags(trim($_POST['queryType'])));
    $location = htmlspecialchars(strip_tags(trim($_POST['nearestLocation'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        $mail = new PHPMailer(true);

        try {
            // === YOUR UPDATED CREDENTIALS ===
            $your_gmail = 'alikahanekom@gmail.com';           
            $your_app_password = 'yitfqdgxefgbtpkb';          
            $business_email = 'alikahanekom@gmail.com';      
            // === END OF CREDENTIALS ===
            
            // SMTP Server Settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $your_gmail;
            $mail->Password   = $your_app_password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->Timeout    = 30;

            // Recipients
            $mail->setFrom($your_gmail, 'Athenos Website Contact');
            $mail->addAddress($business_email, 'Athenos Restaurant');
            $mail->addReplyTo($email, "$firstName $lastName");

            // Content
            $mail->isHTML(false);
            $mail->Subject = "Athenos Website: New Inquiry from $firstName $lastName";
            
            $body = "========================================\n";
            $body .= "NEW CONTACT FORM SUBMISSION\n";
            $body .= "========================================\n\n";
            $body .= "Name: $firstName $lastName\n";
            $body .= "Email: $email\n";
            $body .= "Mobile: " . ($mobile ? $mobile : 'Not provided') . "\n";
            $body .= "Query Type: " . ($queryType ? $queryType : 'Not specified') . "\n";
            $body .= "Nearest Location: " . ($location ? $location : 'Not specified') . "\n\n";
            $body .= "Message:\n";
            $body .= "----------------------------------------\n";
            $body .= "$message\n";
            $body .= "----------------------------------------\n\n";
            $body .= "Sent on: " . date('Y-m-d H:i:s') . "\n";
            
            $mail->Body = $body;

            $mail->send();
            $message_sent = true;
            
            // Store success in session and redirect
            $_SESSION['contact_success'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
            
        } catch (Exception $e) {
            $error_message = "Message could not be sent. Error: " . $mail->ErrorInfo;
        }
    }
}

// Check for session success message
if (isset($_SESSION['contact_success'])) {
    $message_sent = true;
    unset($_SESSION['contact_success']);
}
?>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="contact-section">
            <div class="contact-info">
                <h2>GET IN TOUCH</h2>
                <p>We'd love to hear from you...</p>
                <div class="contact-details">
                    <p><i class="fas fa-phone"></i> 074 2732 934</p>
                    <p><i class="fas fa-envelope"></i> alikahanekom@gmail.com</p>
                </div>
            </div>

            <div class="contact-form">
                <h2>SEND US AN EMAIL</h2>
                
                <?php if ($message_sent && empty($error_message)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        Thank you! Your message has been sent successfully. We'll get back to you soon.
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> 
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form id="contactForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-grid">
                        <input type="text" name="firstName" placeholder="First Name" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required>
                        <input type="text" name="lastName" placeholder="Last Name" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" required>

                        <input type="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <input type="text" name="mobileNumber" placeholder="Mobile Number" value="<?php echo isset($_POST['mobileNumber']) ? htmlspecialchars($_POST['mobileNumber']) : ''; ?>">

                        <input type="text" name="queryType" placeholder="Query Type" class="full" value="<?php echo isset($_POST['queryType']) ? htmlspecialchars($_POST['queryType']) : ''; ?>">
                        <input type="text" name="nearestLocation" placeholder="Nearest Location" class="full" value="<?php echo isset($_POST['nearestLocation']) ? htmlspecialchars($_POST['nearestLocation']) : ''; ?>">

                        <div class="captcha-container full">
                            <div class="captcha-box">
                                <span id="captcha-question">Security Check: Loading...</span>
                                <input type="text" id="captcha-answer" name="captcha_answer" placeholder="Answer" required>
                            </div>
                        </div>

                        <textarea name="message" placeholder="Message" class="full" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>

                    <button type="submit">SEND <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Generate random numbers for CAPTCHA
            const num1 = Math.floor(Math.random() * 10) + 1;
            const num2 = Math.floor(Math.random() * 10) + 1;
            const correctAnswer = num1 + num2;
            window.captchaAnswer = correctAnswer;

            const captchaQuestion = document.getElementById("captcha-question");
            if (captchaQuestion) {
                captchaQuestion.textContent = `Security Check: ${num1} + ${num2} = ?`;
            }

            const form = document.getElementById("contactForm");
            if (form) {
                form.addEventListener("submit", function (event) {
                    const userAnswer = document.getElementById("captcha-answer").value.trim();
                    
                    if (parseInt(userAnswer) !== window.captchaAnswer) {
                        event.preventDefault();
                        alert("Incorrect security answer. Please try again!");
                        document.getElementById("captcha-answer").value = "";
                        document.getElementById("captcha-answer").focus();
                        
                        // Generate new CAPTCHA
                        const newNum1 = Math.floor(Math.random() * 10) + 1;
                        const newNum2 = Math.floor(Math.random() * 10) + 1;
                        window.captchaAnswer = newNum1 + newNum2;
                        captchaQuestion.textContent = `Security Check: ${newNum1} + ${newNum2} = ?`;
                    }
                });
            }
        });
    </script>
</body>
</html>