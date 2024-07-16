<?php  
include('includes/header.php');
include('../includes/session.php');
?>
<?php $get_periodCode = $_GET['view']; ?>

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
                                <h4>Evaluation Details</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Evaluation Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Evaluation Details</h2>
                            <div class="pb-20">
                                <div class="form-background">
                                    <table id="objectivesTable" class="data-table table stripe">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Task</th>
                                                <th>Description</th>
                                                <th>Period</th>
                                                <th>Self Score</th>
                                                <th>Evaluator Score</th>
                                                <th>Evaluator Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user_id = $_SESSION['userId'];

                                            $sql = "SELECT CONCAT('C', common_kpi.id) AS id, 
                                                           common_kpi.code, 
                                                           common_kpi.description, 
                                                           common_kpi.period, 
                                                           '' AS kpi_indicator, 
                                                           '' AS unit_of_measure, 
                                                           '' AS target, 
                                                           'CommonMetric' AS category,
                                                           er.self_score,
                                                           er.evaluator_score,
                                                           er.evaluator_remarks
                                                    FROM common_kpi
                                                    JOIN employee_rating er
                                                    ON common_kpi.id = CAST(SUBSTRING(er.evaluation_item_code, 2) AS UNSIGNED)
                                                    WHERE er.evaluation_item_category = 'CommonMetric'  
                                                      AND er.evaluation_period = :periodCode
                                                      AND er.evaluatee_id = :userId
                                                    UNION ALL
                                                    SELECT employee_objectives.id as id, 
                                                           employee_objectives.objective_code as code, 
                                                           employee_objectives.details as description, 
                                                           employee_objectives.period, 
                                                           employee_objectives.kpi_indicator, 
                                                           employee_objectives.unit_of_measure, 
                                                           employee_objectives.target, 
                                                           'TargetMetric' AS category,
                                                           er.self_score,
                                                           er.evaluator_score,
                                                           er.evaluator_remarks
                                                    FROM employee_objectives
                                                    JOIN employee_rating er
                                                    ON er.evaluation_item_code = employee_objectives.id
                                                    WHERE er.evaluation_item_category = 'TargetMetric' 
                                                      AND er.evaluation_period = :periodCode 
                                                      AND er.evaluatee_id = :userId";
                                            
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':periodCode', $get_periodCode, PDO::PARAM_STR);
                                            $query->bindParam(':userId', $user_id, PDO::PARAM_INT);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>  
                                                    <tr>
                                                        <td><?php echo htmlentities($result->id); ?></td>
                                                        <td><?php echo htmlentities($result->code); ?></td>
                                                        <td><?php echo htmlentities($result->description); ?></td>
                                                        <td><?php echo htmlentities($result->period); ?></td>
                                                        <td><?php echo htmlentities($result->self_score); ?></td>
                                                        <td><?php echo htmlentities($result->evaluator_score); ?></td>
                                                        <td><?php echo htmlentities($result->evaluator_remarks); ?></td>
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
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/scripts.php')?>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#objectivesTable')) {
                $('#objectivesTable').DataTable({
                    "order": [[0, "asc"]]
                });
            }
        });
    </script>
</body>
</html>
