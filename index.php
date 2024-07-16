<?php
session_start();
include('includes/db_settings.php');
if(isset($_POST['signin']))
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);

	$sql ="SELECT * FROM users where email ='$username' AND Password ='$password'";
	$query= mysqli_query($conn, $sql);
	$count = mysqli_num_rows($query);
	if($count > 0)
	{
		while ($row = mysqli_fetch_assoc($query)) {
		    if ($row['role_id'] == '1') {
		    	$_SESSION['userId']=$row['user_id'];
		    	$_SESSION['userRole']=$row['role_id'];
				$_SESSION['empId']=$row['emp_id'];
			 	echo "<script type='text/javascript'> document.location = 'admin/admin_dashboard.php'; </script>";
		    }
			elseif ($row['role_id'] == '2') {
		    	$_SESSION['userId']=$row['user_id'];
		    	$_SESSION['userRole']=$row['role_id'];
				$_SESSION['empId']=$row['emp_id'];
			 	echo "<script type='text/javascript'> document.location = 'supervisor/index.php'; </script>";
		    }
		    elseif ($row['role_id'] == '3') {
		    	$_SESSION['userId']=$row['user_id'];
		    	$_SESSION['userRole']=$row['role_id'];
				$_SESSION['empId']=$row['emp_id'];
			 	echo "<script type='text/javascript'> document.location = 'evaluatee/index.php'; </script>";
		    }
		


		    else {
		    	$_SESSION['userId']=$row['user_id'];
		    	$_SESSION['userRole']=$row['role_id'];
				$_SESSION['empId']=$row['emp_id'];
			 	echo "<script type='text/javascript'> document.location = 'hr/index.php'; </script>";
		    }
			
		}

	} 
	else{
	  
	  echo "<script>alert('Invalid Details');</script>";

	}

}?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Employee Performance Appraisal System</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
	<link rel="stylesheet" type="text/css" href="src/styles/style.css">

	

	
</head>
<body class="login-page">
	
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row">
		<div class="s_title">Employee Performance Appraisal System</div>
             </div>
			 
			<div class="row align-items-center">
				
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center ">Login Below</h2>
						</div>
						<form name="signin" method="post">
						
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Email Address" name="username" id="username">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="password here"name="password" id="password">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								
								<div class="col-6">
									<div class="forgot-password"><a href="forgot_password.php">Forgot Password</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
									   <input class="btn btn-primary btn-lg btn-block" name="signin" id="signin" type="submit" value="Sign In">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>