<?php
include('includes/header.php');
include('../includes/session.php');

$empid = $_SESSION['empId'];

if (isset($_POST['new_update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $phonenumber = $_POST['phonenumber'];

    $result = mysqli_query($conn, "UPDATE employee SET FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Department='$department', Address='$address', Phonenumber='$phonenumber' WHERE emp_id='$empid'") or die(mysqli_error($conn));
    
    if ($result) {
        echo "<script>alert('Your records Successfully Updated');</script>";
        echo "<script type='text/javascript'> document.location = 'staff_profile.php'; </script>";
    } else {
        die(mysqli_error($conn));
    }
}

if (isset($_POST["update_image"])) {
    $image = $_FILES['image']['name'];

    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
        $location = $image;
    } else {
        echo "<script>alert('Please Select Picture to Update');</script>";
    }

    $result = mysqli_query($conn, "UPDATE employee SET location='$location' WHERE emp_id='$empid'") or die(mysqli_error($conn));
    
    if ($result) {
        echo "<script>alert('Profile Picture Updated');</script>";
        echo "<script type='text/javascript'> document.location = 'staff_profile.php'; </script>";
    } else {
        die(mysqli_error($conn));
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
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Profile</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <?php
                            $query_profile = mysqli_query($conn, "SELECT * FROM employee LEFT JOIN department ON employee.Department = department.DepartmentShortName WHERE emp_id = '$empid'") or die(mysqli_error($conn));
                            if ($query_profile && mysqli_num_rows($query_profile) > 0) {
                                $row_profile = mysqli_fetch_array($query_profile);
                            } else {
                                $row_profile = null;
                            }
                            ?>

                            <div class="profile-photo">
                                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                <img src="<?php echo (!empty($row_profile['location'])) ? '../uploads/' . $row_profile['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="" class="avatar-photo">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="weight-500 col-md-12 pd-5">
                                                    <div class="form-group">
                                                        <div class="custom-file">
                                                            <input name="image" id="file" type="file" class="custom-file-input" accept="image/*" onchange="validateImage('file')">
                                                            <label class="custom-file-label" for="file" id="selector">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="update_image" value="Update" class="btn btn-primary">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php if ($row_profile) { ?>
                                <h5 class="text-center h5 mb-0"><?php echo $row_profile['FirstName'] . " " . $row_profile['LastName']; ?></h5>
                                <p class="text-center text-muted font-14"><?php echo $row_profile['DepartmentName']; ?></p>
                                <div class="profile-info">
                                    <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                                    <ul>
                                        <li>
                                            <span>Email Address:</span>
                                            <?php echo $row_profile['EmailId']; ?>
                                        </li>
                                        <li>
                                            <span>Phone Number:</span>
                                            <?php echo $row_profile['Phonenumber']; ?>
                                        </li>
                                        <li>
                                            <span>Address:</span>
                                            <?php echo $row_profile['Address']; ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <p>No profile information available.</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#setting" role="tab">Update Profile</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="profile-edit-list row">
                                                        <div class="col-md-12"><h4 class="text-blue h5 mb-20">Edit Your Personal Setting</h4></div>

                                                        <?php
                                                        $query_info = mysqli_query($conn, "SELECT * FROM employee WHERE emp_id = '$empid'") or die(mysqli_error($conn));
                                                        if ($query_info && mysqli_num_rows($query_info) > 0) {
                                                            $row_info = mysqli_fetch_array($query_info);
                                                        } else {
                                                            $row_info = null;
                                                        }
                                                        ?>
                                                        <?php if ($row_info) { ?>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>First Name</label>
                                                                    <input name="fname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row_info['FirstName']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Last Name</label>
                                                                    <input name="lastname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row_info['LastName']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email Address</label>
                                                                    <input name="email" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row_info['EmailId']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Phone Number</label>
                                                                    <input name="phonenumber" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row_info['Phonenumber']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Date Of Birth</label>
                                                                    <input name="dob" class="form-control form-control-lg date-picker" type="text" required="true" autocomplete="off" value="<?php echo $row_info['Dob']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                    <select name="gender" class="custom-select form-control" required="true" autocomplete="off" disabled>
                                                                        <option value="<?php echo $row_info['Gender']; ?>"><?php echo $row_info['Gender']; ?></option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <input name="address" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row_info['Address']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Department</label>
                                                                    <select name="department" class="custom-select form-control" required="true" autocomplete="off" disabled>
                                                                        <?php
                                                                        $query_staff = mysqli_query($conn, "SELECT * FROM employee JOIN department WHERE emp_id = '$empid'") or die(mysqli_error($conn));
                                                                        if ($query_staff && mysqli_num_rows($query_staff) > 0) {
                                                                            $row_staff = mysqli_fetch_array($query_staff);
                                                                        } else {
                                                                            $row_staff = null;
                                                                        }
                                                                        ?>
                                                                        <?php if ($row_staff) { ?>
                                                                            <option value="<?php echo $row_staff['DepartmentShortName']; ?>"><?php echo $row_staff['DepartmentName']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="">No department found</option>
                                                                        <?php } ?>

                                                                        <?php
                                                                        $query_departments = mysqli_query($conn, "SELECT * FROM department");
                                                                        while ($row_department = mysqli_fetch_array($query_departments)) {
                                                                            ?>
                                                                            <option value="<?php echo $row_department['DepartmentShortName']; ?>"><?php echo $row_department['DepartmentName']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="weight-500 col-md-6">
                                                                <div class="form-group">
                                                                    <label></label>
                                                                    <div class="modal-footer justify-content-center">
                                                                        <button class="btn btn-primary" name="new_update" id="new_update" data-toggle="modal">Save & Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                            <p>No information available for update.</p>
                                                        <?php } ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Setting Tab End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>

    <script type="text/javascript">
        var loader = function(e) {
            let file = e.target.files;

            let show = "<span>Selected file : </span>" + file[0].name;
            let output = document.getElementById("selector");
            output.innerHTML = show;
            output.classList.add("active");
        };

        let fileInput = document.getElementById("file");
        fileInput.addEventListener("change", loader);
    </script>
    <script type="text/javascript">
        function validateImage(id) {
            var formData = new FormData();
            var file = document.getElementById(id).files[0];
            formData.append("Filedata", file);
            var t = file.type.split('/').pop().toLowerCase();
            if (t != "jpeg" && t != "jpg" && t != "png") {
                alert('Please select a valid image file');
                document.getElementById(id).value = '';
                return false;
            }
            if (file.size > 1050000) {
                alert('Max Upload size is 1MB only');
                document.getElementById(id).value = '';
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
