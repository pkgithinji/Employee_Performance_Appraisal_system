<?php
include('includes/header.php');
include('../includes/session.php');
include('includes/navbar.php');
include('includes/right_sidebar.php');
include('includes/left_sidebar.php');


$logged_in_user_id = $_SESSION['userId'];


$sql_emp_id = "SELECT emp_id FROM users WHERE user_id = ?";
$stmt_emp_id = $conn->prepare($sql_emp_id);
$stmt_emp_id->bind_param("i", $logged_in_user_id);
$stmt_emp_id->execute();
$result_emp_id = $stmt_emp_id->get_result();

if ($result_emp_id->num_rows > 0) {
    $row_emp_id = $result_emp_id->fetch_assoc();
    $supervisor_emp_id = $row_emp_id['emp_id'];

    
    $sql = "SELECT e.emp_id, e.FirstName, e.LastName, e.EmailId, d.DepartmentName
            FROM employee e
            LEFT JOIN department d ON e.Department = d.DepartmentShortName
            WHERE e.supervisor_id = ?
            AND e.status = 1
            ORDER BY e.emp_id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $supervisor_emp_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h3 mb-0">My Supervision List</h2>
        </div>
        
        <div class="card-box mb-30">
            <div class="pd-20">
                <h2 class="text-blue h4">Employees to Evaluate</h2>
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
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="avatar mr-2 flex-shrink-0">
                                            <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $row['EmailId']; ?></td>
                                <td><?php echo $row['DepartmentName']; ?></td>
                                
<td>
													<div class="table-actions">
														<a href="supervisorEvaluation.php?view=<?php echo $row['emp_id']; ?>" data-color="#265ed7">Evaluate</a>
													
													</div>
												</td>
                               
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
           </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
</div>
<!-- js -->
<?php include('includes/scripts.php'); ?>
</body>
</html>
<?php
} else {
    
    echo "N";
}
?>
