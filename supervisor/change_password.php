<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
if(isset($_POST['change_password'])) {
    $user_id = $_SESSION['userId']; // Assuming the user is changing their own password
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the user's current password from the database
    $user_query = mysqli_query($conn, "SELECT password FROM users WHERE user_id = '$user_id'");
    $user = mysqli_fetch_assoc($user_query);

    if(!$user) {
        echo "<script>alert('User not found');</script>";
    } elseif(md5($old_password) != $user['password']) {
        echo "<script>alert('Old password is incorrect');</script>";
    } elseif($new_password != $confirm_password) {
        echo "<script>alert('New password and confirm password do not match');</script>";
    } else {
        // Update the user's password in the database
        $new_password_hashed = md5($new_password);
        $update_password = mysqli_query($conn, "UPDATE users SET password='$new_password_hashed' WHERE user_id='$user_id'") or die(mysqli_error($conn));

        if($update_password) {
            echo "<script>alert('Password successfully changed');</script>";
            echo "<script>window.location = 'index.php';</script>";
        }
    }
}
?>

<body>
    <?php include('includes/navbar.php')?>
    <?php include('includes/right_sidebar.php')?>
    <?php include('includes/left_sidebar.php')?>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Change Password</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Change Password</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Old Password:</label>
                                            <input name="old_password" type="password" placeholder="**********" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>New Password:</label>
                                            <input name="new_password" type="password" placeholder="**********" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Confirm New Password:</label>
                                            <input name="confirm_password" type="password" placeholder="**********" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="change_password" id="change_password" data-toggle="modal">Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>

            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>
</body>
</html>
