<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
// get date passed from website and convert it in order to check database
$q = intval($_GET['q']);
$year = substr($q,0,4);
$month = substr($q,4,2);
$day = substr($q,6);
$mydate = $year.'-'.$month.'-'.$day;
$mytime = date("h:i");

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
$myid = mysqli_real_escape_string($con,$_SESSION['login_id']);
$sqlget = "SELECT * FROM geyma WHERE `id-pelati`='$myid' AND `imerominia`='$q'";
$sqldata = mysqli_query($con, $sqlget) or die('error getting date');
// create table of meals
echo '<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Ημερομηνία</th>
<th>Τύπος γεύματος</th>
<th>Γεύμα</th>
<th></th>
</tr>
</thead>
<tbody>';
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    if ($row['typos-geymatos']==1) {
        $typosgeymatos = "Πρωινό";
    }
    elseif ($row['typos-geymatos']==2) {
        $typosgeymatos = "Πρόγευμα";
    }
    elseif ($row['typos-geymatos']==3) {
        $typosgeymatos = "Γεύμα";
    }
    elseif ($row['typos-geymatos']==4) {
        $typosgeymatos = "Απογευματινό";
    }
    elseif ($row['typos-geymatos']==5) {
        $typosgeymatos = "Δείπνο";
    }
    echo "<tr><td>"; 
    echo $row['imerominia'];
    echo "</td><td>";   
    echo $typosgeymatos;
    echo "</td><td>";   
    echo $row['sxolia-diaitologou'];
    echo "</td><td>";
    echo '<a href="#mealedit" type="submit" class="btn btn-default editButton" data-toggle="modal" data-meal-id="'.$row['id-geymatos'].'" data-meal-time="'.$mytime.'">feedback</a>';
    echo "</td></tr>";
}
echo "</tbody>
</table>
</div>";
mysqli_close($con);
?>
</body>
</html>