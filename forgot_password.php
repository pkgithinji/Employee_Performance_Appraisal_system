<?php
session_start();
include('includes/db_settings.php');
require "vendors/emailconfig/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'email_config.php';

if(isset($_POST['reset'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // Generate a random token

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    if($count > 0) {
        // Store the token in the database
        $sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        mysqli_query($conn, $sql);

        // Send reset password email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = EMAIL;
            $mail->Password = PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(EMAIL, 'Employee Performance Appraisal System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Hi,<br><br>Click the link below to reset your password:<br><br>
                              <a href='http://localhost:8383/epas/reset_password.php?token=$token'>Reset Password</a><br><br>
                              Thank you.";

            $mail->send();
            echo "<script>alert('A password reset link has been sent to your email address.');</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email address not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
    <link rel="stylesheet" type="text/css" href="src/styles/style.css">
</head>
<body class="login-page">
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center">Forgot Password</h2>
                        </div>
                        <form method="post">
                            <div class="input-group custom">
                                <input type="email" class="form-control form-control-lg" placeholder="Email ID" name="email" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                       <input class="btn btn-primary btn-lg btn-block" name="reset" type="submit" value="Reset">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="forgot-password"><a href="index.php">Back to Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>
