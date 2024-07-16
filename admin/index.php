<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>
	

	<?php include('includes/navbar.php')?>

	
	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						
					</div>
					<div class="col-md-8">

						

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Employee Performance Evaluation System	</h4>
						<p class="font-18 max-width-600"></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">My Supervision List</div>
							<div class="table-actions">
								<a title="VIEW" href="#"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
								 $emp_id = $_SESSION['empId'];
		                         $query = mysqli_query($conn,"select * from employee where supervisor_id='$emp_id'") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                       
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											</div>
										<div class="txt">
												<div class="font-16 weight-500" data-color="#000"><?php echo $row['FirstName'].' '.$row['LastName']; ?></div>
										</div>
									</div>
									</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
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