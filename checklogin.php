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
$myusername = mysqli_real_escape_string($con,$_POST['myusername']);
$mypassword = mysqli_real_escape_string($con,$_POST['mypassword']);
$sql1="SELECT * FROM diaitologos WHERE username='$myusername' AND password='$mypassword'";
$resultdiaitologos=mysqli_query($con,$sql1);
$row = mysqli_fetch_array($resultdiaitologos, MYSQLI_ASSOC);
$iddiaitologou=$row["id-diaitologou"];	
$sql2="SELECT * FROM pelatis WHERE username='$myusername' AND password='$mypassword'";
$resultpelatis=mysqli_query($con,$sql2);
$row = mysqli_fetch_array($resultpelatis, MYSQLI_ASSOC);
$idpelati=$row["id-pelati"];
// Mysql_num_row is counting table row
$count1=mysqli_num_rows($resultdiaitologos);
$count2=mysqli_num_rows($resultpelatis);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count1==1){
	// Register $myusername, and redirect to file "logged-diaitologos.php"
	$_SESSION['login_user'] = $myusername;
	$_SESSION['login_id'] = $iddiaitologou;
	header("location: logged-diaitologos.php");
}
elseif ($count2==1) {
	// Register $myusername, and redirect to file "logged-pelatis.php"
	$_SESSION['login_user'] = $myusername;
	$_SESSION['login_id'] = $idpelati;
	$_SESSION['date'] = date('d/m/y');
	header("location: logged-pelatis.php");
}
else {
	ob_start();
	echo '<script language="javascript">';
	echo 'alert("Λάθος username/password! Παρακαλώ προσπαθήστε ξανά.")';
	echo '</script>';
	header('Refresh: 0; URL = index.php');
	ob_end_flush();
}
?>
