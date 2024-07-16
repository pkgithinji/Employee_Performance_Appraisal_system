<?php  
include('includes/header.php');
include('../includes/session.php');
?>
<?php $get_periodCode = $_GET['view']; ?>
<?php 
if (isset($_POST['submit_scores'])) {
    $self_evaluation_date = date("Y-m-d");
    $user_id = $_SESSION['userId'];

    // Check if there are existing records for this user and period
    $existing_check_sql = "SELECT * FROM employee_rating WHERE evaluatee_id='$user_id' AND evaluation_period='$get_periodCode'";
    $existing_check_result = mysqli_query($conn, $existing_check_sql);
    if (mysqli_num_rows($existing_check_result) > 0) {
        echo "<script>alert('There is an existing evaluation for this user and period.');</script>";
    } else {
        foreach ($_POST['scores'] as $evaluation_item_code => $self_score) {
            if ($self_score < 1 || $self_score > 5) {
                echo "<script>alert('Scores must be between 1 and 5.');</script>";
                echo "<script type='text/javascript'> document.location = 'selfEvaluationList.php'; </script>";
                exit();
            }
            $evaluation_period = $_POST['evaluation_periods'][$evaluation_item_code];
            $rating_category = $_POST['metric_category'][$evaluation_item_code]; // Get the category for each item
            $sql = "INSERT INTO employee_rating (evaluation_period, evaluatee_id, evaluation_item_code, self_score, self_evaluation_date, evaluation_item_category) VALUES ('$evaluation_period', '$user_id', '$evaluation_item_code', '$self_score', '$self_evaluation_date', '$rating_category')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die(mysqli_error($conn));
            }
        }
        echo "<script>alert('Scores have been successfully submitted');</script>";
        echo "<script type='text/javascript'> document.location = 'selfEvaluationList.php'; </script>";
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
                                <h4>Employee Self Evaluation</h4>
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
                                        <table id="objectivesTable" class="data-table table stripe">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Task</th>
                                                    <th>Description</th>
                                                    <th>Period</th>
                                                    <th>Indicator</th>
                                                    <th>Unit of Measure</th>
                                                    <th>Target</th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $user_id = $_SESSION['userId'];
                                              /*  $sql = "SELECT * FROM (
                                                            SELECT id, objective_code, details, period, kpi_indicator, unit_of_measure, target, 'TargetMetric' as category
                                                            FROM employee_objectives where user_id='$user_id'
                                                            and period='$get_periodCode'
                                                            UNION 
                                                            SELECT CONCAT('C', id) AS id, code, description, period, '', '', '', 'CommonMetric' as category
                                                            FROM common_kpi where period='$get_periodCode'
                                                        ) p 
                                                        ORDER BY p.id";

*/
$sql = "SELECT CONCAT('C', common_kpi.id) AS id, 
       common_kpi.code, 
       common_kpi.description, 
       common_kpi.period, 
       '' AS kpi_indicator, 
       '' AS unit_of_measure, 
       '' AS target, 
       'CommonMetric' AS category 
FROM common_kpi
JOIN employee_rating 
ON common_kpi.id = CAST(SUBSTRING(employee_rating.evaluation_item_code, 2) AS UNSIGNED)
WHERE employee_rating.evaluation_item_category = 'CommonMetric'  and period='$get_periodCode'
UNION ALL
SELECT employee_objectives.id as id, 
       employee_objectives.objective_code as code, 
       employee_objectives.details as description, 
       employee_objectives.period, 
       employee_objectives.kpi_indicator, 
       employee_objectives.unit_of_measure, 
       employee_objectives.target, 
       'TargetMetric' AS category 
FROM employee_objectives
JOIN employee_rating 
ON employee_rating.evaluation_item_code = employee_objectives.id
WHERE employee_rating.evaluation_item_category = 'TargetMetric' and period='$get_periodCode' and  user_id='$user_id';
";
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
                                                            <td><?php echo htmlentities($result->kpi_indicator); ?></td>
                                                            <td><?php echo htmlentities($result->unit_of_measure); ?></td>
                                                            <td><?php echo htmlentities($result->target); ?></td>
                                                            <td>
                                                                <input type="number" name="scores[<?php echo $result->id; ?>]" class="form-control" required min="1" max="5">
                                                                <input type="hidden" name="evaluation_periods[<?php echo $result->id; ?>]" value="<?php echo htmlentities($result->period); ?>">
                                                                <input type="hidden" name="metric_category[<?php echo $result->id; ?>]" value="<?php echo htmlentities($result->category); ?>">
                                                            </td>
                                                        </tr>
                                                    <?php $cnt++; }
                                                } ?>  
                                            </tbody>
                                        </table>
                                        <div class="col-sm-12 mt-3 text-right">
                                            <input type="submit" name="submit_scores" class="btn btn-primary" value="Submit Scores">
                                        </div>
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
                    "order": [[0, "asc"]]
                });
            }
        });
    </script>
</body>
</html>
