<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
    if(isset($_POST['add_user']))
    {
        $emp_id = $_POST['employee_id'];
        $password = md5($_POST['password']); 
        $status = 1;
        $created_by = $_SESSION['userId'];
        $user_role = $_POST['user_role'];
        
        $role_id_query = mysqli_query($conn, "SELECT role_id FROM user_role WHERE role_name='$user_role'");
        $role_row = mysqli_fetch_assoc($role_id_query);
        $role_id = $role_row['role_id'];

        // Fetch employee details
        $employee_query = mysqli_query($conn,"SELECT * FROM employee WHERE emp_id = '$emp_id'") or die(mysqli_error($conn));
        $employee = mysqli_fetch_assoc($employee_query);
        
        if (!$employee) {
            echo "<script>alert('Employee not found');</script>";
        } else {
            $fname = $employee['FirstName'];
            $lname = $employee['LastName'];   
            $email = $employee['EmailId'];

            // Check if user already exists
            $user_check_query = mysqli_query($conn,"SELECT * FROM users WHERE email = '$email'") or die(mysqli_error($conn));
            $count = mysqli_num_rows($user_check_query);

            if ($count > 0){ ?>
                <script>
                    alert('User Already Exists');
                </script>
            <?php } else {
                // Insert into users table
                $insert_user = mysqli_query($conn,"INSERT INTO users (emp_id, email, password, first_name, last_name, status, created_by, role_id,last_modified_by) VALUES ('$emp_id', '$email', '$password', '$fname', '$lname', '$status', '$created_by', '$role_id','$created_by')") or die(mysqli_error($conn));
                
                if ($insert_user) {
                    echo "<script>alert('User Successfully Added');</script>";
                    echo "<script>window.location = 'users.php';</script>";
                }
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
                            <h4 class="text-blue h4">Create User</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee :</label>
                                            <select id="employee_id" name="employee_id" class="form-control" required="true" autocomplete="off">
                                                <option value="">Select Employee</option>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM employee");
                                                while($row = mysqli_fetch_array($query)){
                                                ?>
                                                <option value="<?php echo $row['emp_id']; ?>"><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Password :</label>
                                            <input name="password" type="password" placeholder="**********" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>User Role :</label>
                                            <select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Role</option>
                                                <?php
                                                $role_query = mysqli_query($conn, "SELECT * FROM user_role");
                                                while($role_row = mysqli_fetch_array($role_query)){
                                                ?>
                                                <option value="<?php echo $role_row['role_name']; ?>"><?php echo $role_row['role_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_user" id="add_user" data-toggle="modal">Add User</button>
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
    <script>
        $(document).ready(function() {
            $('#employee_id').select2({
                placeholder: "Select an Employee",
                allowClear: true
            });
        });
    </script>
</body>
</html>
