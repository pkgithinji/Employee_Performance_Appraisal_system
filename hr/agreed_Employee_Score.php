<?php
include('includes/header.php');
include('../includes/session.php');

$sql_active_period = "SELECT code FROM evaluation_periods WHERE status = 1";
$query_active_period = mysqli_query($conn, $sql_active_period);
$row_active_period = mysqli_fetch_assoc($query_active_period);
$get_periodCode = $row_active_period['code'];

$supervisor_id = $_SESSION['userId'];

$get_empCode = isset($_GET['view']) ? $_GET['view'] : '';

$subordinate_user_id = '';
if (!empty($get_empCode)) {
    $sql_subordinate_user_id = "SELECT user_id FROM users WHERE emp_id = '$get_empCode'";
    $query_subordinate_user_id = mysqli_query($conn, $sql_subordinate_user_id);
    if ($query_subordinate_user_id && mysqli_num_rows($query_subordinate_user_id) > 0) {
        $row_subordinate_user_id = mysqli_fetch_assoc($query_subordinate_user_id);
        $subordinate_user_id = $row_subordinate_user_id['user_id'];
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
                                <h4>Employee Evaluation</h4>
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
                            <h2 class="mb-30 h4">Target Evaluation</h2>
                            <div class="pb-20">
                                <div class="form-background">
                                    <form method="post" action="" onsubmit="return validateScores()">
                                        <table id="objectivesTable" class="table stripe">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Task</th>
                                                    <th>Description</th>
                                                    <th>Period</th>
                                                    <th>Self Score</th>
                                                    <th>Evaluator Score</th>
                                                   <th>Agreed Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                  if (!empty($subordinate_user_id)) {
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
                                                   er.evaluator_remarks,
                                                   er.agreed_score
                                            FROM common_kpi
                                            JOIN employee_rating er
                                            ON common_kpi.id = CAST(SUBSTRING(er.evaluation_item_code, 2) AS UNSIGNED)
                                            WHERE er.evaluation_item_category = 'CommonMetric'  
                                              AND er.evaluation_period = '$get_periodCode'
                                              AND er.evaluatee_id = '$subordinate_user_id'
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
                                                   er.evaluator_remarks,
                                                   er.agreed_score
                                            FROM employee_objectives
                                            JOIN employee_rating er
                                            ON er.evaluation_item_code = employee_objectives.id
                                            WHERE er.evaluation_item_category = 'TargetMetric' 
                                              AND er.evaluation_period = '$get_periodCode'
                                              AND er.evaluatee_id = '$subordinate_user_id'";
                                          
                                                    $query = $dbh->prepare($sql);
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
                                                                <td><?php echo htmlentities($result->agreed_score); ?></td>
                                                                
                                                                
                                                            </tr>
                                                        <?php $cnt++; }
                                                    }
                                                }
                                                ?>  
                                            </tbody>
                                        </table>

                                    </form>
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
        function validateScores() {
            let valid = true;
            const scores = document.querySelectorAll('input[name^="scores"]');
            scores.forEach(score => {
                if (score.value < 1 || score.value > 5) {
                    valid = false;
                    alert('Scores must be between 1 and 5.');
                }
            });
            return valid;
        }

        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#objectivesTable')) {
                $('#objectivesTable').DataTable({
                    "order": [[0, "asc"]],
                    "paging": false, 
            "searching": false, 
            "info": false
                });
            }
        });
    </script>
</body>
</html>
