<?php
include("config.php");
session_start();
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
$myid = mysqli_real_escape_string($con,$_SESSION['login_id']);
$mydate = mysqli_real_escape_string($con,$_POST['feedbackdate']);
$mycomments = mysqli_real_escape_string($con,$_POST['feedbackcomments']);
$sql="INSERT INTO `sxolia-imeras` (`id-pelati`, imerominia, sxolio)
	VALUES 
	('$myid', '$mydate', '$mycomments')";


// If query executed succefully
if (mysqli_multi_query($con, $sql)) {
	// get last inserted id into 'pelatis' table
	ob_start();
	echo '<script language="javascript">';
	echo 'alert("Επιτυχής Καταχώρηση!")';
	echo '</script>';
	header('Refresh: 1; URL = logged-pelatis.php');
	ob_end_flush();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>