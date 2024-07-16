<?php 
include('includes/header.php');
include('../includes/session.php');

if (isset($_GET['delete'])) {
    $objective_id = $_GET['delete'];
    $user_id = $_SESSION['userId'];
    
    $sql = "DELETE FROM employee_objectives WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $objective_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Individual Target deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'employeeObjectives.php'; </script>";
    }
}
?>

<?php
if (isset($_POST['add'])) {
    $individual_objectiveCode = $_POST['objectiveCode'];
    $description = $_POST['description'];
    $objective_period = $_POST['objective_period'];
    $kpiIndicator = $_POST['kpi_indicator'];
    $uom = $_POST['unit_of_measure'];
    $emp_target = $_POST['target'];
    $user_id = $_SESSION['userId'];

    $query = mysqli_query($conn, "SELECT * FROM employee_objectives WHERE objective_code = '$individual_objectiveCode' AND user_id = '$user_id'") or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>alert('This Individual Target Already exists');</script>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO employee_objectives (objective_code, details, period, kpi_indicator, unit_of_measure, target, user_id)
             VALUES ('$individual_objectiveCode', '$description', '$objective_period', '$kpiIndicator', '$uom', '$emp_target', '$user_id')") or die(mysqli_error());

        if ($query) {
            echo "<script>alert('Individual Target Added Successfully');</script>";
            echo "<script type='text/javascript'> document.location = 'employeeObjectives.php'; </script>";
        }
    }
}

$periods = [];
$sql = "SELECT code FROM evaluation_periods WHERE status = 1";
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
                                <h4>Manage Individual Targets</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee Targets</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Create Performance Target</h2>
                            <section>
                                <form name="save" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Task</label>
                                                <textarea name="objectiveCode" style="height: 5em;" required="true" class="form-control text_area" type="text"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" required="true" style="height: 5em;" class="form-control text_area" type="text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Period</label>
                                                <select required="true" name="objective_period" class="form-control">
                                                    <?php foreach ($periods as $period): ?>
                                                        <option value="<?php echo $period; ?>"><?php echo $period; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Indicator</label>
                                                <input name="kpi_indicator" required="true" class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Unit of Measure</label>
                                                <input name="unit_of_measure" required="true" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Target</label>
                                                <input name="target" required="true" class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                        <div class="dropdown">
                                            <input class="btn btn-primary" type="submit" value="Add" name="add" id="add">
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">List of Targets</h2>
                            <div class="pb-20">
                                <form method="GET" action="employeeObjectives.php">
                                    <label for="filter_period">Filter by Period:</label>
                                    <select name="filter_period" id="filter_period" onchange="this.form.submit()">
                                        <option value="">All Periods</option>
                                        <?php foreach ($periods as $period): ?>
                                            <option value="<?php echo $period; ?>" <?php if (isset($_GET['filter_period']) && $_GET['filter_period'] == $period) echo 'selected'; ?>><?php echo $period; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                                <table id="objectivesTable" class="data-table table stripe">
                                    <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Description</th>
                                            <th>Period</th>
                                            <th>Indicator</th>
                                            <th>Unit of Measure</th>
                                            <th>Target</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $user_id = $_SESSION['userId'];
                                        $sql = "SELECT eo.* FROM employee_objectives eo
                                                JOIN evaluation_periods ep ON eo.period = ep.code
                                                WHERE eo.user_id = ? AND ep.status = 1";

                                        if (isset($_GET['filter_period']) && !empty($_GET['filter_period'])) {
                                            $selected_period = $_GET['filter_period'];
                                            $sql .= " AND eo.period = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("is", $user_id, $selected_period);
                                        } else {
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $user_id);
                                        }
                                        
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) { ?>  
                                            <tr>
                                                <td><?php echo htmlentities($row['objective_code']); ?></td>
                                                <td><?php echo htmlentities($row['details']); ?></td>
                                                <td><?php echo htmlentities($row['period']); ?></td>
                                                <td><?php echo htmlentities($row['kpi_indicator']); ?></td>
                                                <td><?php echo htmlentities($row['unit_of_measure']); ?></td>
                                                <td><?php echo htmlentities($row['target']); ?></td>
                                                <td>
                                                    <div class="table-actions">
                                                        <a href="edit_objective.php?edit=<?php echo htmlentities($row['id']); ?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                                        <a href="employeeObjectives.php?delete=<?php echo htmlentities($row['id']); ?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>  
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
    <!-- js -->
    <?php include('includes/scripts.php')?>
    <script>
        $(document).ready(function() {
            $('#objectivesTable').DataTable();
        });
    </script>
</body>
</html>
