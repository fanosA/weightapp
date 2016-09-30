<?php
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
$myusername = mysqli_real_escape_string($con,$_POST['myusername']);
$mypassword = mysqli_real_escape_string($con,$_POST['mypassword']);
$myname = mysqli_real_escape_string($con,$_POST['myname']);
$mylastname = mysqli_real_escape_string($con,$_POST['mylastname']);
$myweight = mysqli_real_escape_string($con,$_POST['myweight']);
$mysex = mysqli_real_escape_string($con,$_POST['mysex']);
$myage = mysqli_real_escape_string($con,$_POST['myage']);
$mycomments = mysqli_real_escape_string($con,$_POST['mycomments']);
$sql="INSERT INTO pelatis (username, password, onoma, epitheto, baros, filo, ilikia, sxolia)
	VALUES 
	('$myusername', '$mypassword', '$myname', '$mylastname', '$myweight', '$mysex', '$myage', '$mycomments')";


// If query executed succefully
if (mysqli_multi_query($con, $sql)) {
	// get last inserted id into 'pelatis' table
	ob_start();
	session_start();
	$last_id = mysqli_insert_id($con);
	$connected_id = mysqli_real_escape_string($con,$_SESSION["login_id"]);
	$sql2="INSERT INTO `diaitologos-pelatis` (`id-diaitologou`, `id-pelati`)
	VALUES
	('$connected_id', '$last_id')";
	mysqli_multi_query($con, $sql2);
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