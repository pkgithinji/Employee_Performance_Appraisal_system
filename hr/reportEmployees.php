<?php
ob_start(); // Start output buffering
include('includes/header.php');
include('../includes/session.php');
?>

<!-- HTML body -->
<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20">
            <style>
                .export-btn {
                    float: right;
                }
            </style>
            <div class="title pb-20">
                <a href="report_employeeList.php" class="btn btn-success export-btn"><i class="glyphicon glyphicon-print"></i> Export to PDF</a>
                <h2 class="h3 mb-0">Employees List</h2>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">ALL EMPLOYEES</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus">FULL NAME</th>
                                <th>EMAIL</th>
                                <th>DEPARTMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $teacher_query = mysqli_query($conn, "SELECT * FROM employee LEFT JOIN department ON employee.Department = department.DepartmentShortName WHERE status=1 ORDER BY employee.emp_id") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($teacher_query)) {
                                $id = $row['emp_id'];
                            ?>
                                <tr>
                                    <td class="table-plus">
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="avatar mr-2 flex-shrink-0">
                                                <img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
                                            </div>
                                            <div class="txt">
                                                <div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $row['EmailId']; ?></td>
                                    <td><?php echo $row['DepartmentName']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/scripts.php') ?>
</body>

</html>
<?php ob_end_flush(); // End output buffering ?>
