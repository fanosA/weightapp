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
$myid = mysqli_real_escape_string($con,$_POST['myid']);

$sql="DELETE FROM pelatis WHERE `id-pelati`='$myid'";


// If query executed succefully
if (mysqli_multi_query($con, $sql)) {
	ob_start();
	echo '<script language="javascript">';
	echo 'alert("Επιτυχής διαγραφή!")';
	echo '</script>';
	header('Refresh: 1; URL = logged-diaitologos.php');
	ob_end_flush();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>

