<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php 
	 if (isset($_GET['delete'])) {
		$kpi_id = $_GET['delete'];
		$sql = "DELETE FROM common_kpi where id = ".$kpi_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('KPI deleted Successfully');</script>";
     		echo "<script type='text/javascript'> document.location = 'commonKPI.php'; </script>";
			
		}
	}                            $periods = [];
    $sql = "SELECT code FROM evaluation_periods";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $periods[] = $row['code'];
        }
    }
?>

<?php
 if(isset($_POST['edit']))
{
	$kpi_code=$_POST['kpiCode'];
	 $kpi_description=$_POST['descr'];
	 $kpi_period=$_POST['kpi_period'];
     

    $result = mysqli_query($conn,"update common_kpi set code = '$kpi_code' , description ='$kpi_description',period='$kpi_period' where id = '$get_id' ");
    if ($result) {
     	echo "<script>alert(' KPI successfully updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'commonKPI.php'; </script>";
	} else{
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
									<h4>Common KPI List</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit KPIs</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Edit Key Performance Metric</h2>
								<section>
									<?php
									$query = mysqli_query($conn,"SELECT * from common_kpi where id = '$get_id'")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
                                    $selected_period = $row['period'];

									?>

     
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label > Code</label>
												<input name="kpiCode" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['code']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Description</label>
												<input name="descr" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:Capitalize" value="<?php echo $row['description']; ?>">
											</div>
										</div>
									</div>
                                    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Period</label>
            <select required="true" name="kpi_period" class="form-control">
                <?php foreach($periods as $period): ?>
                    <option value="<?php echo $period; ?>" <?php if ($period == $selected_period) echo 'selected'; ?>>
                        <?php echo $period; ?>
                    </option>
                <?php endforeach; ?>
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
								<h2 class="mb-30 h4">Performance Indiators List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th class="table-plus"> Code</th>
											<th>Description</th>
                                            <th>Period</th>
                                           
											<th class="datatable-nosort">Action</th>
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from common_kpi order by id desc";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												<td> <?php echo htmlentities($cnt);?></td>
	                                            <td><?php echo htmlentities($result->code);?></td>
	                                            <td><?php echo htmlentities($result->description);?></td>
                                                <td><?php echo htmlentities($result->period);?></td>
												
												<td>
													<div class="table-actions">
														<a href="commonKPI.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
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