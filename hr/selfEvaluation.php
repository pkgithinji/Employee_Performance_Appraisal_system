<?php include('includes/header.php'); include('../includes/session.php'); ?>

<?php $get_periodCode = $_GET['view']; ?>

<?php
// Fetch minimum and maximum points
$sql = "SELECT MIN(points) AS min_points, MAX(points) AS max_points FROM scores_setup";
$query = $dbh->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);
$min_points = $result->min_points;
$max_points = $result->max_points;

if (isset($_POST['submit_scores'])) {
    $self_evaluation_date = date("Y-m-d");
    $user_id = $_SESSION['userId'];
    
    foreach ($_POST['scores'] as $evaluation_item_code => $self_score) {
        if ($self_score < $min_points || $self_score > $max_points) {
            echo "<script>alert('Score for $evaluation_item_code must be between $min_points and $max_points');</script>";
            echo "<script type='text/javascript'> document.location = 'employeeTargets.php'; </script>";
            exit;
        }
        $rating_category = $_POST['categ'][$evaluation_item_code];

        $evaluation_period = $_POST['evaluation_periods'][$evaluation_item_code];
        $sql = "INSERT INTO employee_rating (evaluation_period, evaluatee_id, evaluation_item_code, self_score, self_evaluation_date, evaluation_item_category) VALUES ('$evaluation_period', '$user_id', '$evaluation_item_code', '$self_score', '$self_evaluation_date', '$rating_category')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    echo "<script>alert('Scores have been successfully submitted');</script>";
    echo "<script type='text/javascript'> document.location = 'selfEvaluationList.php'; </script>";
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
                            <h2 class="mb-30 h4">Self Evaluation</h2>
                            <div class="pb-20">
                                <div class="form-background">
                                    <form method="post" action="" id="evaluationForm">
                                        <input type="hidden" id="min_points" value="<?php echo $min_points; ?>">
                                        <input type="hidden" id="max_points" value="<?php echo $max_points; ?>">
                                        <table id="objectivesTable" class="table stripe">
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
                                                
                                                $sql = "SELECT * FROM (
                                                            SELECT id, objective_code, details, period, kpi_indicator, unit_of_measure, target,'TargetMetric' as m                                                      FROM employee_objectives WHERE user_id='$user_id' AND period='$get_periodCode'
                                                            UNION 
                                                            SELECT CONCAT('C', id) AS id, code, description, period, '', '', '','CommonMetric' as m
                                                            FROM common_kpi WHERE period='$get_periodCode'
                                                        ) p 
                                                        ORDER BY p.id";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) { ?>  
                                                        <tr>
                                                            <td><?php echo htmlentities($result->id); ?></td>
                                                            <td><?php echo htmlentities($result->objective_code); ?></td>
                                                            <td><?php echo htmlentities($result->details); ?></td>
                                                            <td><?php echo htmlentities($result->period); ?></td>
                                                            <td><?php echo htmlentities($result->kpi_indicator); ?></td>
                                                            <td><?php echo htmlentities($result->unit_of_measure); ?></td>
                                                            <td><?php echo htmlentities($result->target); ?></td>
                                                            
                                                            <td>
                                                                <input type="number" name="scores[<?php echo $result->id; ?>]" class="form-control score-input" min="<?php echo $min_points; ?>" max="<?php echo $max_points; ?>">
                                                                <input type="hidden" name="evaluation_periods[<?php echo $result->id; ?>]" value="<?php echo htmlentities($result->period); ?>">
                                                                <input type="hidden" name="categ[<?php echo $result->id; ?>]" value="<?php echo htmlentities($result->m); ?>">
                                                     
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
    <!-- js -->
    <?php include('includes/scripts.php')?>
    <script>
        $(document).ready(function() {
            $('#evaluationForm').submit(function(event) {
                const scoreInputs = document.querySelectorAll('.score-input');
                let hasValidScores = false;

                scoreInputs.forEach(input => {
                    if (input.value !== '') {
                        hasValidScores = true;
                    } else {
                        input.disabled = true;
                    }
                });

                if (!hasValidScores) {
                    alert('Please enter scores for at least one objective.');
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
