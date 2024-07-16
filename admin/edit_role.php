<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>

<?php 
	if (isset($_GET['delete'])) {
		$role_id = $_GET['delete'];
		$sql = "DELETE FROM user_role where role_id = ".$role_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Role deleted Successfully');</script>";
			echo "<script type='text/javascript'> document.location = 'roles.php'; </script>";
		}
	}
?>

<?php
	if(isset($_POST['edit']))
	{
		$rolename = $_POST['rolename'];
		$status = $_POST['status'];

		$result = mysqli_query($conn, "UPDATE user_role SET role_name = '$rolename', status = '$status' WHERE role_id = '$get_id'");
		
		if ($result) {
			echo "<script>alert('Record Successfully Updated');</script>";
			echo "<script type='text/javascript'> document.location = 'roles.php'; </script>";
		} else {
			die(mysqli_error());
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
								<h4>Role List</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Role</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4">Edit Role</h2>
							<section>
								<?php
									$query = mysqli_query($conn, "SELECT * FROM user_role WHERE role_id = '$get_id'") or die(mysqli_error());
									$row = mysqli_fetch_array($query);
								?>

								<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Role Name</label>
												<input name="rolename" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['role_name']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Status</label>
												<select name="status" class="form-control" required>
													<option value="1" <?php if($row['status'] == 1) echo "selected"; ?>>Active</option>
													<option value="0" <?php if($row['status'] == 0) echo "selected"; ?>>Inactive</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 text-right">
										<div class="dropdown">
											<input class="btn btn-primary" type="submit" value="UPDATE" name="edit" id="edit">
										</div>
									</div>
								</form>
							</section>
						</div>
					</div>
					
					<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4">Role List</h2>
							<div class="pb-20">
								<table class="data-table table stripe hover nowrap">
									<thead>
										<tr>
											<th>SR NO.</th>
											<th class="table-plus">ROLE NAME</th>
											<th>STATUS</th>
											<th class="datatable-nosort">ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sql = "SELECT * FROM user_role";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if($query->rowCount() > 0) {
												foreach($results as $result) { ?>  
													<tr>
														<td><?php echo htmlentities($cnt);?></td>
														<td><?php echo htmlentities($result->role_name);?></td>
														<td><?php echo ($result->status == 1) ? 'Active' : 'Inactive'; ?></td>
														<td>
															<div class="table-actions">
																<a href="edit_role.php?edit=<?php echo htmlentities($result->role_id);?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
																<a href="roles.php?delete=<?php echo htmlentities($result->role_id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
															</div>
														</td>
													</tr>
													<?php $cnt++;
												} 
											} 
										?>  
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
