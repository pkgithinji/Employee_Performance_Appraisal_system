<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
if(isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    $user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
    $user = mysqli_fetch_assoc($user_query);

    if(!$user) {
        echo "<script>alert('User not found');</script>";
        echo "<script>window.location = 'users.php';</script>";
    }
}

if(isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $emp_id = $_POST['employee_id'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : $user['password'];
    $status = isset($_POST['status']) ? 1 : 0;
    $updated_by = $_SESSION['userId'];
    $user_role = $_POST['user_role'];
    date_default_timezone_set('Africa/Nairobi');
    $dt = date('Y-m-d H:i:s');
    $role_id_query = mysqli_query($conn, "SELECT role_id FROM user_role WHERE role_name='$user_role'");
    $role_row = mysqli_fetch_assoc($role_id_query);
    $role_id = $role_row['role_id'];

    $update_user = mysqli_query($conn, "UPDATE users SET emp_id='$emp_id', password='$password', status='$status', role_id='$role_id', last_modified_by='$updated_by', last_modified_on='$dt' WHERE user_id='$user_id'") or die(mysqli_error($conn));

    if($update_user) {
        echo "<script>alert('User Successfully Updated');</script>";
        echo "<script>window.location = 'users.php';</script>";
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
                                <h4>Staff Portal</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Edit User</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <section>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Full Name:</label>
                                            <input type="text" class="form-control" value="<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee:</label>
                                            <select id="employee_id" name="employee_id" class="form-control" required="true" autocomplete="off">
                                                <option value="">Select Employee</option>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM employee");
                                                while($row = mysqli_fetch_array($query)){
                                                    $selected = $row['emp_id'] == $user['emp_id'] ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $row['emp_id']; ?>" <?php echo $selected; ?>><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>New Password (leave blank if not changing):</label>
                                            <input name="password" type="password" placeholder="**********" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>User Role:</label>
                                            <select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Role</option>
                                                <?php
                                                $role_query = mysqli_query($conn, "SELECT * FROM user_role");
                                                while($role_row = mysqli_fetch_array($role_query)){
                                                    $selected = $role_row['role_id'] == $user['role_id'] ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $role_row['role_name']; ?>" <?php echo $selected; ?>><?php echo $role_row['role_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Status:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="status" name="status" <?php echo $user['status'] == 1 ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="update_user" id="update_user" data-toggle="modal">Update User</button>
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
