<?php  
include('includes/header.php');
include('../includes/session.php');
?>
<?php $get_periodCode = isset($_GET['period']) ? $_GET['period'] : '';
  
 
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
                                <h4>Employee Performance Overview</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee Performance</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-left">
                            <form method="get" action="">
                                <label for="period" style="color: #007bff; font-weight: bold;">Select Evaluation Period:</label>
                                <select name="period" id="period" onchange="this.form.submit()" style="color: #007bff; border: 2px solid #007bff; padding: 5px; border-radius: 5px;">
                                    <option value="">Select Period</option>
                                    <?php
                                    $sql = "SELECT code FROM evaluation_periods";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $periods = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($periods as $period) { ?>
                                        <option value="<?php echo htmlentities($period->code); ?>" <?php if($get_periodCode == $period->code) echo 'selected'; ?>>
                                            <?php echo htmlentities($period->code); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Employee Performance</h2>
                            <div class="pb-20">
                                <div class="form-background">
                                    <table id="employeeScoresTable" class="data-table table stripe">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Average Agreed Score</th>
                                                <th>Recommendation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($get_periodCode) {
                                                $sql="select t.*,AVG(er.agreed_score) AS avg_agreed_score, recommendation_engine(AVG(er.agreed_score))as recomm from (SELECT e.emp_id, CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, e.Department,u.user_id from employee e inner join users u on e.emp_id=u.emp_id )t inner join employee_rating er ON t.user_id = er.evaluatee_id 
                                                WHERE er.evaluation_period = :period
                                                AND er.evaluatee_id = :userId
                                      GROUP BY t.emp_id, t.EmployeeName, t.Department";

                                      $user_id = $_SESSION['userId'];
 
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':period', $get_periodCode, PDO::PARAM_STR);
                                                $query->bindParam(':userId', $user_id, PDO::PARAM_INT);
                                                   
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) { ?>  
                                                        <tr>
                                                            <td><?php echo htmlentities($result->emp_id); ?></td>
                                                            <td><?php echo htmlentities($result->EmployeeName); ?></td>
                                                            <td><?php echo htmlentities($result->Department); ?></td>
                                                            <td><?php echo htmlentities(number_format($result->avg_agreed_score, 2)); ?></td>
                                                            <td><?php echo htmlentities($result->recomm); ?></td>
                                                      
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4">No records found for the selected period.</td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="4">Please select a period to view the agreed scores.</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/scripts.php')?>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#employeeScoresTable')) {
                $('#employeeScoresTable').DataTable({
                    "order": [[0, "asc"]]
                });
            }
        });
    </script>
</body>
</html>
