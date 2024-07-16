<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>
	

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			
			<div class="title pb-20">
				<h2 class="h3 mb-0">Admin Dashboard</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from employee";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$emp_count=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($emp_count);?></div>
								<div class="font-14 text-secondary weight-500">Employees</div>
							</div>
							<div class="widget-icon">
    <div class="icon" data-color="#00eccf"><i class="fa fa-user"></i></div>
</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=1;
						$sql = "SELECT id from department";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$department_count=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($department_count); ?></div>
								<div class="font-14 text-secondary weight-500">Departments</div>
							</div>
							<div class="widget-icon">
    <div class="icon" data-color="#00eccf"><i class="fa fa-building"></i></div>
</div>

						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

					<?php 
						 $query_reg_staff = mysqli_query($conn,"select * from employee where is_supervisor=1 and status=1")or die(mysqli_error());
						 $count_reg_staff = mysqli_num_rows($query_reg_staff);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_staff); ?></div>
								<div class="font-14 text-secondary weight-500">Supervisors</div>
							</div>
							<div class="widget-icon">
    <div class="icon" data-color="#00eccf"><i class="fa fa-balance-scale"></i></div>
</div>

						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=2;
						$sql = "SELECT id from designation";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$designations=$query->rowCount();
						?>  

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($designations); ?></div>
								<div class="font-14 text-secondary weight-500">Designations</div>
							</div>
							<div class="widget-icon">
    <div class="icon" data-color="#00eccf"><i class="fa fa-id-badge"></i></div>
</div>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Corporate Objectives</div>
							<div class="table-actions">
								<a title="VIEW" href="corporate_objectives_list.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select c.code from corporate_objectives c inner join evaluation_periods e on c.period=e.code where e.status=1") or die(mysqli_error());
		                         while ($row_objectives = mysqli_fetch_array($query)) {
		                         
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
								
									<div class="font-16 weight-500" data-color="#17a2b8"><?php echo $row_objectives['code']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Individual Objectives </div>
							<div class="table-actions">
								<a title="VIEW" href="#"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select c.objective_code from employee_objectives c inner join evaluation_periods e on c.period=e.code where e.status=1") or die(mysqli_error());
		                         while ($row_objectives = mysqli_fetch_array($query)) {
		                         
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
								
									<div class="font-16 weight-500" data-color="#17a2b8"><?php echo $row_objectives['objective_code']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
<div class="col-lg-4 col-md-6 mb-20">
    <div class="card-box height-100-p pd-20 min-height-200px">
        <div class="d-flex justify-content-between pb-10">
            <div class="h5 mb-0">Important Dates</div>
            <div class="table-actions">
                <a title="VIEW" href="#"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>
            </div>
        </div>
        <div class="user-list">
            <ul>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM evaluation_periods WHERE status=1") or die(mysqli_error($conn));
                while ($row_periods = mysqli_fetch_array($query)) {
                  
                ?>
                    <li class="d-flex align-items-center justify-content-between">
                        <div class="txt">
                            <div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row_periods['code']; ?></div>
                            <div class="font-14 weight-600">
                                Objectives Submission: <?php echo $row_periods['objectives_submission_startdate'] . " - " . $row_periods['objectives_submission_enddate']; ?><br>
                                Self Evaluation: <?php echo $row_periods['self_evaluation_startdate'] . " - " . $row_periods['self_evaluation_enddate']; ?><br>
                                Supervisor Evaluation: <?php echo $row_periods['supervisor_evaluation_startdate'] . " - " . $row_periods['supervisor_evaluation_enddate']; ?><br>
                                Agreed Score Submission: <?php echo $row_periods['agreedscore_submission_startdate'] . " - " . $row_periods['agreedscore_submission_enddate']; ?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
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