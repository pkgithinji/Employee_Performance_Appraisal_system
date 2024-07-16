<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php 
    if (isset($_GET['delete'])) {
        $objective_id = $_GET['delete'];
        $sql = "DELETE FROM corporate_objectives WHERE id = ".$objective_id;
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Performance Metric deleted Successfully');</script>";
            echo "<script type='text/javascript'> document.location = 'corporate_objectives.php'; </script>";
        }
    }
?>

<?php
 if(isset($_POST['add']))
{
     $objective_code=$_POST['objectiveCode'];
     $objective_description=$_POST['descr'];
     $objective_period=$_POST['objective_period'];
     $query = mysqli_query($conn,"SELECT * FROM corporate_objectives WHERE code = '$objective_code'") or die(mysqli_error());
     $count = mysqli_num_rows($query);
     
     if ($count > 0){ 
        echo "<script>alert('This objective Already exists');</script>";
      }
      else{
        $query = mysqli_query($conn,"INSERT INTO corporate_objectives (code, description, period)
         VALUES ('$objective_code', '$objective_description', '$objective_period')") or die(mysqli_error()); 

        if ($query) {
            echo "<script>alert('objective Added Successfully');</script>";
            echo "<script type='text/javasccript'> document.location = 'corporate_objetives.php'; </script>";
        }
    }
}

$periods = [];
$sql = "SELECT code FROM evaluation_periods";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $periods[] = $row['code'];
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
                                    <h4>Manage Corporate Objectives</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Corporate Objectives</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                            <div class="card-box pd-30 pt-10 height-100-p">
                                <h2 class="mb-30 h4">Create Corporate Objective</h2>
                                <section>
                                    <form name="save" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Metric</label>
                                                <textarea name="objectiveCode" style="height: 5em;" required class="form-control text_area" type="text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="descr" required style="height: 5em;" class="form-control text_area" type="text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Period</label>
                                                <select required name="objective_period" class="form-control">
                                                    <?php foreach($periods as $period): ?>
                                                        <option value="<?php echo $period; ?>"><?php echo $period; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                        <input class="btn btn-primary" type="submit" value="Add" name="add" id="add">
                                    </div>
                                   </form>
                                </section>
                            </div>
                        </div>
                        
                                
                        <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                            <div class="card-box pd-30 pt-10 height-100-p">
                                <h2 class="mb-30 h4">List of Corporate Objectives</h2>
                                <div class="pb-20">
                                    <table class="data-table table stripe hover">
                                        <thead>
                                        <tr>
                                            <th class="table-plus">Metric</th>
                                            <th class="table-plus">Description</th>
                                            <th class="table-plus">Period</th>
                                        
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php $sql = "SELECT * FROM corporate_objectives";
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
                                                <td><?php echo htmlentities($result->period);?></td>                                    
                                                                         
                                                <td>
                                                    <div class="table-actions">
                                                        <a href="edit_corporate_objectives.php?edit=<?php echo htmlentities($result->id);?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                                        <a href="corporate_objectives.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
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
