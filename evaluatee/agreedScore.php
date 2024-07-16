<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php 
	 if (isset($_GET['delete'])) {
		$period_id = $_GET['delete'];
		$sql = "DELETE FROM evaluation_periods where id = ".$period_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Period deleted Successfully');</script>";
     		echo "<script type='text/javascript'> document.location = 'periods.php'; </script>";
			
		}
	}
?>

<?php
 if(isset($_POST['add']))
{
	 $periodCode=$_POST['period_Code'];
	 $description=$_POST['descr'];
	 $dtefrom=date('d-m-Y', strtotime($_POST['date_from']));
	 $dteto=date('d-m-Y', strtotime($_POST['date_to']));
     
	 $submissionDeadline=date('d-m-Y', strtotime($_POST['objectiveSubmissionDeadline']));
   
     $query = mysqli_query($conn,"select * from evaluation_periods where code = '$periodCode'")or die(mysqli_error());
	 $count = mysqli_num_rows($query);
     
     if ($count > 0){ 
     	echo "<script>alert('This Period Already exist');</script>";
      }
      else{
        $query = mysqli_query($conn,"insert into evaluation_periods (code, description, date_from, date_to,objective_submission_deadline)
  		 values ('$periodCode', '$description', '$dtefrom', '$dteto','$submissionDeadline')      
		") or die(mysqli_error()); 

		if ($query) {
			echo "<script>alert('Period Added Succesfully');</script>";
			echo "<script type='text/javascript'> document.location = 'periods.php'; </script>";
		}
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
										<li class="breadcrumb-item active" aria-current="page"> Manage Evaluation </li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

			
						
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">List of Active Evaluations</h2>
								<div class="pb-20">
									<table class="data-table table stripe ">
										<thead>
										<tr>
											<th class="table-plus">Code</th>
											<th class="table-plus">Description</th>
											<th table-plus>Period Date Range</th>
											<th class="datatable-nosort">Action</th>
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from evaluation_periods where status=1";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												<td> <?php echo htmlentities($result->code);?></td>
	                                            <td><?php echo htmlentities($result->description);?></td>
												
	                                            <td><?php echo htmlentities($result->date_from." - ".$result->date_to);?></td>
												<td>
													<div class="table-actions">
														<a href="agreedScoreView.php?view=<?php echo htmlentities($result->code);?>" data-color="#265ed7">View</a>
														
													</div>
												</td>
											</tr>

											<?php $cnt++;} }?>  

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
</body>
</html>