<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<?php
if (isset($_GET['delete'])) {
    $period_id = $_GET['delete'];
    $sql = "DELETE FROM evaluation_periods WHERE id = $period_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Period deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'periods.php'; </script>";
    }
}

if (isset($_POST['edit'])) {
    $period_id = $_POST['period_id'];
    $periodCode = $_POST['period_Code'];
    $description = $_POST['descr'];
    $dtefrom = date('Y-m-d', strtotime($_POST['date_from']));
    $dteto = date('Y-m-d', strtotime($_POST['date_to']));
    $objSubStart = date('Y-m-d', strtotime($_POST['objectives_submission_startdate']));
    $objSubEnd = date('Y-m-d', strtotime($_POST['objectives_submission_enddate']));
    $selfEvalStart = date('Y-m-d', strtotime($_POST['self_evaluation_startdate']));
    $selfEvalEnd = date('Y-m-d', strtotime($_POST['self_evaluation_enddate']));
    $supEvalStart = date('Y-m-d', strtotime($_POST['supervisor_evaluation_startdate']));
    $supEvalEnd = date('Y-m-d', strtotime($_POST['supervisor_evaluation_enddate']));
    $agrScoreStart = date('Y-m-d', strtotime($_POST['agreedscore_submission_startdate']));
    $agrScoreEnd = date('Y-m-d', strtotime($_POST['agreedscore_submission_enddate']));
    $modifiedBy = $_SESSION['userId']; 
    $status = $_POST['status'];
    $modifiedDate = date('Y-m-d H:i:s');

    $query = "UPDATE evaluation_periods SET 
                code = '$periodCode', 
                description = '$description', 
                date_from = '$dtefrom', 
                date_to = '$dteto', 
                objectives_submission_startdate = '$objSubStart', 
                objectives_submission_enddate = '$objSubEnd', 
                self_evaluation_startdate = '$selfEvalStart', 
                self_evaluation_enddate = '$selfEvalEnd', 
                supervisor_evaluation_startdate = '$supEvalStart', 
                supervisor_evaluation_enddate = '$supEvalEnd', 
                agreedscore_submission_startdate = '$agrScoreStart', 
                agreedscore_submission_enddate = '$agrScoreEnd', 
                last_modified_by = '$modifiedBy', 
                last_modification_date = '$modifiedDate', 
                status = '$status' 
              WHERE id = $period_id";

    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script>alert('Period has been successfully Updated');</script>";
        echo "<script type='text/javascript'> document.location = 'periods.php'; </script>";
    } else {
        die(mysqli_error($conn));
    }
}

if (isset($_GET['edit'])) {
    $get_id = $_GET['edit'];
    $query_periods = mysqli_query($conn, "SELECT * from evaluation_periods where id = '$get_id'") or die(mysqli_error($conn));
    $row_period = mysqli_fetch_array($query_periods);
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
                                <h4>Edit Evaluation Period</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="periods.php">Evaluation Periods</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Period</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Edit Period</h2>
                            <section>
                                <form name="save" method="post">
                                    <input type="hidden" name="period_id" value="<?php echo $row_period['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Period Code</label>
                                                <input name="period_Code" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row_period['code']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="descr" style="height: 5em;" class="form-control text_area" type="text" required="true"><?php echo $row_period['description']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required="true">
                                                    <option value="1" <?php if ($row_period['status'] == 1) echo 'selected'; ?>>Active</option>
                                                    <option value="0" <?php if ($row_period['status'] == 0) echo 'selected'; ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input name="date_from" class="form-control" type="date" required="true" value="<?php echo $row_period['date_from']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input name="date_to" class="form-control" type="date" required="true" value="<?php echo $row_period['date_to']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Objectives Submission Start Date</label>
                                                <input name="objectives_submission_startdate" class="form-control" type="date" required="true" value="<?php echo $row_period['objectives_submission_startdate']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Objectives Submission End Date</label>
                                                <input name="objectives_submission_enddate" class="form-control" type="date" required="true" value="<?php echo $row_period['objectives_submission_enddate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Self Evaluation Start Date</label>
                                                <input name="self_evaluation_startdate" class="form-control" type="date" required="true" value="<?php echo $row_period['self_evaluation_startdate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Self Evaluation End Date</label>
                                                <input name="self_evaluation_enddate" class="form-control" type="date" required="true" value="<?php echo $row_period['self_evaluation_enddate']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Supervisor Evaluation Start Date</label>
                                                <input name="supervisor_evaluation_startdate" class="form-control" type="date" required="true" value="<?php echo $row_period['supervisor_evaluation_startdate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Supervisor Evaluation End Date</label>
                                                <input name="supervisor_evaluation_enddate" class="form-control" type="date" required="true" value="<?php echo $row_period['supervisor_evaluation_enddate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agreed Score Submission Start Date</label>
                                                <input name="agreedscore_submission_startdate" class="form-control" type="date" required="true" value="<?php echo $row_period['agreedscore_submission_startdate']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agreed Score Submission End Date</label>
                                                <input name="agreedscore_submission_enddate" class="form-control" type="date" required="true" value="<?php echo $row_period['agreedscore_submission_enddate']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="edit" class="btn btn-primary">Update Period</button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php') ?>
        </div>
    </div>

    <?php include('includes/scripts.php') ?>

</body>

</html>
