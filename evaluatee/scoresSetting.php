<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>



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
									<h4>Scores Settings</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Manage Scores/Ratings</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
					
						
						<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Scores List</h2>
								<div class="pb-20">
									<table class="data-table table stripe">
										<thead>
										<tr>
											
											<th class=""> Code</th>
											<th>Description</th>
											<th>Points</th>
											
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from scores_setup";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												
	                                            <td><?php echo htmlentities($result->code);?></td>
	                                            <td><?php echo htmlentities($result->description);?></td>
												<td><?php echo htmlentities($result->points);?></td>
												
											
											</tr>

											<?php } }?>  

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