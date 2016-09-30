<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
// get date passed from website and convert it in order to check database
$q1 = intval($_GET['q1']);
$q2 = intval($_GET['q2']);
$idpelati = intval($_GET['q3']);
$startyear = substr($q1,0,4);
$startmonth = substr($q1,4,2);
$startday = substr($q1,6,2);
$endyear = substr($q2,0,4);
$endmonth = substr($q2,4,2);
$endday = substr($q2,6,2);


$startdate = $startyear.'-'.$startmonth.'-'.$startday;
$enddate = $endyear.'-'.$endmonth.'-'.$endday;


session_start();
include('config.php');
// Connect to server and select databse.
$con=mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Change character set to utf8
mysqli_set_charset($con,"utf8");
// select meals from database
$sqlget = "SELECT * FROM geyma WHERE `id-pelati`='$idpelati' AND `imerominia` BETWEEN '$startdate' AND '$enddate'";
$sqldata = mysqli_query($con, $sqlget) or die('error getting date');
// create table of meals
echo '<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Ημερομηνία</th>
<th>Γεύμα</th>
<th>Σχόλια γεύματος</th>
<th>Ώρα</th>
<th></th>
</tr>
</thead>
<tbody>';
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo "<tr><td>"; 
    echo $row['imerominia'];
    echo "</td><td>";   
    echo $row['sxolia-diaitologou'];
    echo "</td><td>";
    echo $row['feedback'];
    echo "</td><td>";
    echo $row['ora-katanalosis'];
    echo "</td></tr>";
}
echo "</tbody>
</table>
</div>";



echo '<h4>Συγκεντρωτικά σχόλια</h4>
<div id="feedbacktable"></div>
<hr style="width: 100%; color: #2965A3; height: 1px; background-color:#2965A3;" />';
$sqlget2 = "SELECT * FROM `sxolia-imeras` WHERE `id-pelati`='$idpelati' AND `imerominia` BETWEEN '$startdate' AND '$enddate'";
$sqldata2 = mysqli_query($con, $sqlget2) or die('error getting date');
// create table of meals
echo '<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Ημερομηνία</th>
<th>Σχόλια ημέρας</th>
<th></th>
</tr>
</thead>
<tbody>';
while ($row = mysqli_fetch_array($sqldata2, MYSQLI_ASSOC)) {
    echo "<tr><td>"; 
    echo $row['imerominia'];
    echo "</td><td>";   
    echo $row['sxolio'];
    echo "</td></tr>";
}
echo "</tbody>
</table>
</div>";


mysqli_close($con);
?>
</body>
</html>