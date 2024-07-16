<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM users WHERE user_id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('User deleted Successfully');</script>";
		echo "<script type='text/javascript'> document.location = 'users.php'; </script>";
	}
}
?>

<body>
	<?php include('includes/navbar.php')?>
	<?php include('includes/right_sidebar.php')?>
	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="title pb-20">
				<h2 class="h3 mb-0">User Management</h2>
			</div>
			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">ALL USERS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">FULL NAME</th>
								<th>EMAIL</th>
								<th>ROLE</th>
								<th>STATUS</th>
								<th>CREATED AT</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								$user_query = mysqli_query($conn, "SELECT users.user_id, users.email, users.first_name, users.last_name, users.status, users.created_at, user_role.role_name 
									FROM users 
									LEFT JOIN user_role ON users.role_id = user_role.role_id 
									ORDER BY users.user_id") or die(mysqli_error($conn));
								
								while ($row = mysqli_fetch_array($user_query)) {
									$id = $row['user_id'];
								?>
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['first_name'] . " " . $row['last_name']; ?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['role_name']; ?></td>
								<td><?php echo ($row['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
								<td><?php echo $row['created_at']; ?></td>
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="edit_user.php?edit=<?php echo $row['user_id'];?>"><i class="dw dw-edit2"></i> Edit</a>
											<a class="dropdown-item" href="users.php?delete=<?php echo $row['user_id'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
										</div>
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

	<?php include('includes/scripts.php')?>
</body>
</html>
