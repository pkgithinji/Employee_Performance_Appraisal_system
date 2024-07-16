<?php
include('includes/header.php');
include('../includes/session.php');

if (isset($_POST['add_staff'])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    $status = 1;
    $is_supervisor = isset($_POST['is_supervisor']) ? 1 : 0;
    $supervisor_id = $_POST['supervisor_id'];
    $designation_id = $_POST['designation']; // New field for designation

    // if email exists check
    $query = mysqli_query($conn, "SELECT * FROM employee WHERE EmailId = '$email'");
    if (!$query) {
        die("Error in query: " . mysqli_error($conn));
    }

    $count = mysqli_num_rows($query);

    if ($count > 0) {
        ?>
        <script>
            alert('Data Already Exist');
        </script>
        <?php
    } else {
        // the next code insert the record
        $insert_query = "INSERT INTO employee (FirstName, LastName, EmailId, Gender, Dob, Department, Address, Phonenumber, Status, location, is_supervisor, supervisor_id, designation)
                         VALUES ('$fname', '$lname', '$email', '$gender', '$dob', '$department', '$address', '$phonenumber', '$status', 'NO-IMAGE-AVAILABLE.jpg', '$is_supervisor', '$supervisor_id', '$designation_id')";
        $result = mysqli_query($conn, $insert_query);

        if (!$result) {
            ?>
            <script>
                alert('Error: <?php echo mysqli_error($conn); ?>');
            </script>
            <?php
        } else {
            ?>
            <script>
                alert('Staff Records Successfully Added');
                window.location = "staff.php";
            </script>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/right_sidebar.php'); ?>
    <?php include('includes/left_sidebar.php'); ?>

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
                                    <li class="breadcrumb-item active" aria-current="page">Staff Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Staff Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name :</label>
                                            <input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name :</label>
                                            <input name="lastname" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email Address :</label>
                                            <input name="email" type="email" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Gender :</label>
                                            <select name="gender" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date Of Birth :</label>
                                            <input name="dob" type="text" class="form-control date-picker" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address :</label>
                                            <input name="address" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department :</label>
                                            <select name="department" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Department</option>
                                                <?php
                                                $query = mysqli_query($conn,"select * from department");
                                                while($row = mysqli_fetch_array($query)){
                                                ?>
                                                <option value="<?php echo $row['DepartmentShortName']; ?>"><?php echo $row['DepartmentName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Supervisor :</label>
                                            <select name="supervisor_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Supervisor</option>
                                                <?php
                                                $query = mysqli_query($conn,"select * from employee where is_supervisor = 1");
                                                while($row = mysqli_fetch_array($query)){
                                                ?>
                                                <option value="<?php echo $row['emp_id']; ?>"><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Designation :</label>
                                            <select name="designation" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select Designation</option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM designation");
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <br>Tick if Employee is a Supervisor<br>
                                            <label>Is Supervisor:</label>
                                            <input type="checkbox" name="is_supervisor" value="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label style="font-size:16px;"><b></b></label>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;Staff</button>
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
    
    <?php include('includes/scripts.php'); ?>
</body>
</html>
