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

if (isset($_POST['add'])) {
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
    $createdOn = date('Y-m-d');
    $createdBy = $_SESSION['userId']; 
    $status = $_POST['status'];

    $query = mysqli_query($conn, "SELECT * FROM evaluation_periods WHERE code = '$periodCode'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>alert('This Period Already exists');</script>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO evaluation_periods (code, description, date_from, date_to, objectives_submission_startdate, objectives_submission_enddate, self_evaluation_startdate, self_evaluation_enddate, supervisor_evaluation_startdate, supervisor_evaluation_enddate, agreedscore_submission_startdate, agreedscore_submission_enddate, created_by, status) VALUES ('$periodCode', '$description', '$dtefrom', '$dteto', '$objSubStart', '$objSubEnd', '$selfEvalStart', '$selfEvalEnd', '$supEvalStart', '$supEvalEnd', '$agrScoreStart', '$agrScoreEnd',  '$createdBy', '$status')") or die(mysqli_error($conn));

        if ($query) {
            echo "<script>alert('Period Added Successfully');</script>";
            echo "<script type='text/javascript'> document.location = 'periods.php'; </script>";
        }
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
                                <h4>Manage Evaluation Periods</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Evaluation Periods</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Create Period</h2>
                            <section>
                                <form name="save" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Period Code</label>
                                                <input name="period_Code" type="text" class="form-control" required="true" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="descr" style="height: 5em;" class="form-control text_area" type="text" required="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required="true">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input name="date_from" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input name="date_to" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Objectives Submission Start Date</label>
                                                <input name="objectives_submission_startdate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Objectives Submission End Date</label>
                                                <input name="objectives_submission_enddate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Self Evaluation Start Date</label>
                                                <input name="self_evaluation_startdate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Self Evaluation End Date</label>
                                                <input name="self_evaluation_enddate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Supervisor Evaluation Start Date</label>
                                                <input name="supervisor_evaluation_startdate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Supervisor Evaluation End Date</label>
                                                <input name="supervisor_evaluation_enddate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agreed Score Submission Start Date</label>
                                                <input name="agreedscore_submission_startdate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agreed Score Submission End Date</label>
                                                <input name="agreedscore_submission_enddate" class="form-control" type="date" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <!-- Spacer column -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label><br>
                                                <button type="submit" class="btn btn-primary btn-block" name="add">Add Period</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="col-md-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">List of Periods</h2>
                            <div class="pb-20">
                                <table class="data-table table stripe">
                                    <thead>
                                        <tr>
                                            <th class="table-plus">Code</th>
                                            <th class="table-plus">Description</th>
                                          
                                            
                                            <th class="table-plus">Status</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT * FROM evaluation_periods";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>  
                                                <tr>
                                                    <td><?php echo htmlentities($result->code); ?></td>
                                                    <td><?php echo htmlentities($result->description); ?></td>
                                             <td><?php echo $result->status == 1 ? "Active" : "Inactive"; ?></td>
                                                    <td>
                                                        <div class="table-actions">
                                                            <a href="edit_period.php?edit=<?php echo htmlentities($result->id); ?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                                            <a href="periods.php?delete=<?php echo htmlentities($result->id); ?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $cnt++; } 
                                        } ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    
    <?php include('includes/scripts.php') ?>
</body>
</html>
