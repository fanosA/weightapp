<?php
session_start();
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
$myidpelati = mysqli_real_escape_string($con,$_POST['myidpelati']);
$myiddiaitologou = mysqli_real_escape_string($con,$_SESSION['login_id']);
$mydate = mysqli_real_escape_string($con,$_POST['mydate']);
$mytype = mysqli_real_escape_string($con,$_POST['mytype']);
$mymealcomments = mysqli_real_escape_string($con,$_POST['mymealcomments']);
$sql="INSERT INTO geyma (`id-diaitologou`, `id-pelati`, imerominia, `typos-geymatos`, `sxolia-diaitologou`)
	VALUES 
	('$myiddiaitologou', '$myidpelati', '$mydate', '$mytype', '$mymealcomments')";


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