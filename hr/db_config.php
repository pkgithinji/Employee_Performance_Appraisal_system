
<?php

$host="localhost";
$username="root";
$pass="";
$db="employee_performance";

$conn=mysqli_connect($host,$username,$pass,$db);
if(!$conn){
	die("Database connection error");
}


?>
