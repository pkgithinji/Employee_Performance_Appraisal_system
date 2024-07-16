<?php
 session_start(); 
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['userId']) || (trim($_SESSION['userId']) == '')) { ?>
<script>
window.location = "../index.php";
</script>
<?php
}
$session_id=$_SESSION['userId'];
$session_depart = $_SESSION['userRole'];
?>