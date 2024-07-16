<?php
//session_start();
include('includes/db_settings.php');

if (isset($_GET['token']) && isset($_POST['reset_password'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $hashed_password = md5($new_password);

        // Check if the token is valid
        $sql = "SELECT * FROM users WHERE reset_token='$token'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            // Update the password in the database
            $update_sql = "UPDATE users SET password='$hashed_password', reset_token=NULL WHERE reset_token='$token'";
            if (mysqli_query($conn, $update_sql)) {
                echo "<script>alert('Password has been reset successfully.');</script>";
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            } else {
                echo "<script>alert('Error updating password.');</script>";
                error_log("Error executing update statement: " . mysqli_error($conn));
            }
        } else {
            echo "<script>alert('Invalid token.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
    <link rel="stylesheet" type="text/css" href="src/styles/style.css">
    <style>
        .btn-dark-green {
            background-color: #006400;
            border-color: #006400;
            color: #fff;
        }
        .btn-dark-green:hover {
            background-color: #004d00;
            border-color: #004d00;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center">Reset Password</h2>
                        </div>
                        <form method="post">
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="New Password" name="new_password" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="Confirm Password" name="confirm_password" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                       <input class="btn btn-dark-green btn-lg btn-block" name="reset_password" type="submit" value="Reset Password">
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
