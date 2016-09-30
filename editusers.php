<?php
session_start();
 if(isset($_GET['idpassed']) /*you can validate the link here*/){
    $_SESSION['idtoedit']=$_GET['idpassed'];
 }
include("config.php");

// Connect to server and select databse.
$con=mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Change character set to utf8
mysqli_set_charset($con,"utf8");

// To protect MySQL injection (more detail about MySQL injection)
$myid = mysqli_real_escape_string($con,$_POST['myid']);
$myname = mysqli_real_escape_string($con,$_POST['myname']);
$mylastname = mysqli_real_escape_string($con,$_POST['mylastname']);
$myweight = mysqli_real_escape_string($con,$_POST['myweight']);
$mysex = mysqli_real_escape_string($con,$_POST['mysex']);
$myage = mysqli_real_escape_string($con,$_POST['myage']);
$mycomments = mysqli_real_escape_string($con,$_POST['mycomments']);

$sql="UPDATE pelatis 
	SET onoma='$myname', epitheto='$mylastname', baros='$myweight',  filo='$mysex', ilikia='$myage', sxolia='$mycomments' WHERE `id-pelati`='$myid'";


// If query executed succefully
if (mysqli_multi_query($con, $sql)) {
	ob_start();
	echo '<script language="javascript">';
	echo 'alert("Επιτυχής Καταχώρηση!")';
	echo '</script>';
	header('Refresh: 1; URL = logged-diaitologos.php');
	ob_end_flush();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>

