<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php $get_id = $_GET['edit']; ?>
<?php
    if (isset($_POST['edit_staff'])) {

        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $department = $_POST['department'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phonenumber'];
        $is_supervisor = isset($_POST['is_supervisor']) ? 1 : 0;
        $supervisor_id = $_POST['supervisor_id'];
        $status = $_POST['status'];

        $result = mysqli_query($conn, "UPDATE employee SET FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Department='$department', Address='$address', Phonenumber='$phonenumber', is_supervisor='$is_supervisor', supervisor_id='$supervisor_id', Status='$status' WHERE emp_id='$get_id'");

        if ($result) {
            echo "<script>alert('Record Successfully Updated');</script>";
            echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
        } else {
            die(mysqli_error($conn));
        }
    }
?>

<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>

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
                                    <li class="breadcrumb-item active" aria-current="page">Staff Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Edit Staff</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM employee WHERE emp_id = '$get_id'") or die(mysqli_error($conn));
                                    $row = mysqli_fetch_array($query);
                                ?>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name :</label>
                                            <input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $row['FirstName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name :</label>
                                            <input name="lastname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email Address :</label>
                                            <input name="email" type="email" class="form-control" required="true" autocomplete="off" value="<?php echo $row['EmailId']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Gender :</label>
                                            <select name="gender" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="<?php echo $row['Gender']; ?>"><?php echo $row['Gender']; ?></option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['Phonenumber']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Status :</label>
                                            <select name="status" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="1" <?php echo ($row['Status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?php echo ($row['Status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date Of Birth :</label>
                                            <input name="dob" type="text" class="form-control date-picker" required="true" autocomplete="off" value="<?php echo $row['Dob']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address :</label>
                                            <input name="address" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['Address']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department :</label>
                                            <select name="department" class="custom-select form-control" required="true" autocomplete="off">
                                                <?php
                                                $query_staff = mysqli_query($conn, "SELECT * FROM employee JOIN department ON employee.Department = department.DepartmentShortName WHERE emp_id = '$get_id'") or die(mysqli_error($conn));
                                                $row_staff = mysqli_fetch_array($query_staff);
                                                ?>
                                                <option value="<?php echo $row_staff['DepartmentShortName']; ?>"><?php echo $row_staff['DepartmentName']; ?></option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM department");
                                                while ($dept_row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <option value="<?php echo $dept_row['DepartmentShortName']; ?>"><?php echo $dept_row['DepartmentName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Supervisor :</label>
                                            <select name="supervisor_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="<?php echo $row['supervisor_id']; ?>">
                                                    <?php
                                                    $sup_query = mysqli_query($conn, "SELECT FirstName, LastName FROM employee WHERE emp_id = '{$row['supervisor_id']}'");
                                                    $sup_row = mysqli_fetch_array($sup_query);
                                                    echo $sup_row['FirstName'] . ' ' . $sup_row['LastName'];
                                                    ?>
                                                </option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM employee WHERE is_supervisor = 1");
                                                while ($sup_row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <option value="<?php echo $sup_row['emp_id']; ?>"><?php echo $sup_row['FirstName'] . ' ' . $sup_row['LastName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
											<br>Tick if Supervisor</br>
                                            <label>Is Supervisor:</label>
                                            <input type="checkbox" name="is_supervisor" value="1" <?php echo ($row['is_supervisor'] == 1) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label style="font-size:16px;"><b></b></label>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-primary" name="edit_staff" id="edit_staff" data-toggle="modal">Update&nbsp;Staff</button>
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
    <?php include('includes/scripts.php') ?>
</body>
</html>
