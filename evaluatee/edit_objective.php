<?php 
include('includes/header.php');
include('../includes/session.php');

$get_id = $_GET['edit'];

if (isset($_GET['delete'])) {
    $objective_id = $_GET['delete'];
    $sql = "DELETE FROM employee_objectives WHERE id = ".$objective_id;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Objective deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'employeeObjectives.php'; </script>";
    }
}
?>

<?php
if (isset($_POST['edit'])) {
    $individual_objectiveCode = $_POST['objectiveCode'];
    $description = $_POST['descr'];
    $objectivePeriod = $_POST['objective_period'];
    $kpiIndicator = $_POST['kpi_indicator'];
    $uom = $_POST['unit_of_measure'];
    $emp_target = $_POST['target'];

    $result = mysqli_query($conn, "UPDATE employee_objectives SET objective_code='$individual_objectiveCode', details='$description', period='$objectivePeriod', kpi_indicator='$kpiIndicator', unit_of_measure='$uom', target='$emp_target' WHERE id = '$get_id'");
    if ($result) {
        echo "<script>alert('Objective has been successfully Updated');</script>";
        echo "<script type='text/javascript'> document.location = 'employeeObjectives.php'; </script>";
    } else {
        die(mysqli_error($conn));
    }
}

$periods = [];
$sql = "SELECT code FROM evaluation_periods WHERE status=1";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $periods[] = $row['code'];
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
                                <h4>Manage Employee Tasks</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee Tasks</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Performance Task</h2>
                            <section>
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM employee_objectives WHERE id = '$get_id'") or die(mysqli_error($conn));
                                    $row = mysqli_fetch_array($query);
                                    $selected_period = $row['period'];
                                ?>
                                <form name="save" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Objective</label>
                                                <input name="objectiveCode" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['objective_code']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Key Performance Indicator</label>
                                                <input name="kpi_indicator" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['kpi_indicator']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Target</label>
                                                <input name="target" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['target']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input name="descr" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:capitalize" value="<?php echo $row['details']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Period</label>
                                                <select required="true" name="objective_period" class="form-control">
                                                    <?php foreach ($periods as $period): ?>
                                                        <option value="<?php echo $period; ?>" <?php if ($period == $selected_period) echo 'selected'; ?>>
                                                            <?php echo $period; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit of Measure</label>
                                                <input name="unit_of_measure" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['unit_of_measure']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                        <div class="dropdown">
                                            <input class="btn btn-primary" type="submit" value="UPDATE" name="edit" id="edit">
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
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
