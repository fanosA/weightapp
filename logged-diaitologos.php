<?php
session_start();
//Log out Back
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
if(!$_SESSION['login_user'])
{
    //Do not show protected data, redirect to login...
    header('Location: index.html');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WeightApp - διαχείριση σωματικού βάρους</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="favicon.ico">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="logged-diaitologos.php">Εφαρμογή διαχείρισης σωματικού βάρους</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Επισκόπηση <span class="sr-only">(current)</span></a></li>
            <li><a href="#addusers" data-toggle = "modal" data-target = "#addusers">
            <span class="glyphicon glyphicon-plus">Εισαγωγή</span></a></li>
            <li><a href="#editusers" data-toggle = "modal" data-target = "#editusers">
            <span class="glyphicon glyphicon-pencil">Τροποποίηση</span></a></li>
            <li><a href="#deleteuser" data-toggle = "modal" data-target = "#deleteuser">
            <span class="glyphicon glyphicon-remove">Διαγραφή</span></a></li>
            <li><a href="#createmeal" data-toggle = "modal" data-target = "#createmeal">
            <span class="glyphicon glyphicon-heart">Δημιουργία προγράμματος διατροφής</span></a></li>
            <li><a href="#report" data-toggle = "modal" data-target = "#report">
            <span class="glyphicon glyphicon-th-list">Συγκεντρωτική ενημέρωση</span></a></li>
          </ul>
        <div class="navbar-text logoutuser">
            <p>Καλώς ήλθατε, 
            <strong>
            <?php
            echo $_SESSION['login_user'];
            ?>
            </strong>
            . Έχετε συνδεθεί ως <em>διαιτολόγος</em>.</p>
            <form role="form" method ="post" action="logout.php">
            <button type="submit" name="Submit" class="btn btn-success">Έξοδος</button>
            </form>
            
        </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Επισκόπηση πελατών μου</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Όνομα</th>
                  <th>Επώνυμο</th>
                  <th>Βάρος</th>
                  <th>Φύλο</th>
                  <th>Ηλικία</th>
                  <th>Σχόλια</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
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
                $connected_id = mysqli_real_escape_string($con,$_SESSION["login_id"]);
                // Select ONLY the cliets of the logged-in user
                $sqlget = "SELECT * FROM `diaitologos-pelatis` JOIN `pelatis` ON `diaitologos-pelatis`.`id-pelati`=`pelatis`.`id-pelati` WHERE `diaitologos-pelatis`.`id-diaitologou`='$connected_id'";
                $sqldata = mysqli_query($con, $sqlget) or die('error getting date');


                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                    $idtopass = $row['id-pelati'];
                    echo "<tr><td>";
                    echo $row['id-pelati'];
                    echo "</td><td>";   
                    echo $row['onoma'];
                    echo "</td><td>";
                    echo $row['epitheto'];
                    echo "</td><td>";   
                    echo $row['baros'];
                    echo "</td><td>";
                    echo $row['filo'];
                    echo "</td><td>";   
                    echo $row['ilikia'];
                    echo "</td><td>";
                    echo $row['sxolia'];
                    echo "</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div><a class="btn btn-info" onclick="xml_reminder()">XML</a></div>
          


    <!-- ================================================================== -->
                                <!-- My Modals -->
    <!-- ================================================================== -->
    <!-- Modal addusers-->
    <div id="addusers" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Εισαγωγή νέου πελάτη</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method ="post" action="addusers.php">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myusername">Username</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="myusername" id="myusername" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mypassword">Password</label>
                            <div class="col-xs-3">
                            <input type="password" class="form-control" name="mypassword" id="mypassword" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myname">Όνομα</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="myname" id="myname" placeholder="Όνομα" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mylastname">Επίθετο</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="mylastname" id="mylastname" placeholder="Επίθετο" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myweight">Βάρος</label>
                            <div class="col-xs-3">
                            <input type="number" class="form-control" name="myweight" id="myweight" placeholder="Βάρος" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mysex">Φύλο</label>
                            <br>
                            <div class="col-xs-3">
                            <select mysex="Φύλο" type="text" class="form-control" name="mysex" id="mysex">
                                <option value="Άνδρας">Άνδρας</option>
                                <option value="Γυναίκα">Γυναίκα</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myage">Ηλικία</label>
                            <div class="col-xs-3">
                            <input type="number" class="form-control" name="myage" id="myage" placeholder="Ηλικία" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label" for="mycomments">*Σχόλια</label>
                            <div class="col-xs-6">
                            <textarea rows="4" cols="50" class="form-control" name="mycomments" id="mycomments" placeholder="Σχόλια"></textarea>
                            <p>*προαιρετικό πεδίο</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Αποθήκευση</button>
                    </form>
                    <p>Θέλετε να αποθηκευτεί ο πελάτης;</p>
                </div>
                <div class="modal-footer">
                    <p class="text-warning"><small>Εάν δεν γίνει αποθήκευση, όλες οι αλλαγές θα χαθούν.</small></p>
                    <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editusers-->
    <div id="editusers" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Επιλέξτε πελάτη για τροποποίηση</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-modal-selecte">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Όνομα</th>
                              <th>Επώνυμο</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
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

                                $sqlget = "SELECT * FROM `diaitologos-pelatis` JOIN `pelatis` ON `diaitologos-pelatis`.`id-pelati`=`pelatis`.`id-pelati` WHERE `diaitologos-pelatis`.`id-diaitologou`='$connected_id'";
                                $sqldata = mysqli_query($con, $sqlget) or die('error getting date');


                                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                                    $idtopass = $row['id-pelati'];
                                    $nametopass = $row['onoma'];
                                    $lastnametopass = $row['epitheto'];
                                    $weighttopass = $row['baros'];
                                    $sextopass = $row['filo'];
                                    $agetopass = $row['ilikia'];
                                    $commentstopass = $row['sxolia'];
                                    echo "<tr><td>";
                                    echo $row['id-pelati']; 
                                    echo "</td><td>";   
                                    echo $row['onoma'];
                                    echo "</td><td>";
                                    echo $row['epitheto'];
                                    echo "</td><td>";
                                    echo '<a href="#finaledit" type="submit" class="btn btn-default editButton" 
                                    data-dismiss="modal" data-toggle="modal" data-user-id="'.$idtopass.'" data-user-name="'.$nametopass.'" data-user-lastname="'.$lastnametopass.'" data-user-weight="'.$weighttopass.'" data-user-sex="'.$sextopass.'" data-user-age="'.$agetopass.'" data-user-comments="'.$commentstopass.'">Τροποποίηση</a>';
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                          </table>

                        <div class="modal-footer">
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal finaledit-->
    <div id="finaledit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Αλλαγή στοιχείων πελάτη</h4>
                </div>
                <div class="modal-body">
                    <!-- The form which is used to populate the item data -->
                        <form id="userForm" method="post" class="form-horizontal" action="editusers.php">
                            <div class="form-group" style="display: none;">
                                <label class="col-xs-3 control-label">ID</label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" name="myid" id="myid" readonly="" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="myname">Όνομα</label>
                                <div class="col-xs-4">
                                    <input type="text" class="form-control" name="myname" id="myname" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="mylastname">Επίθετο</label>
                                <div class="col-xs-4">
                                    <input type="text" class="form-control" name="mylastname" id="mylastname" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="myweight">Βάρος</label>
                                <div class="col-xs-2">
                                    <input type="number" class="form-control" name="myweight" id="myweight" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="mysex">Φύλο</label>
                                <div class="col-xs-3">
                                <select mysex="Φύλο" type="text" class="form-control" name="mysex" id="mysex">
                                    <option value="Άνδρας">Άνδρας</option>
                                    <option value="Γυναίκα">Γυναίκα</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="myage">Ηλικία</label>
                                <div class="col-xs-2">
                                    <input type="number" class="form-control" name="myage" id="myage" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="mycomments">Σχόλια</label>
                                <div class="col-xs-8">
                                    <textarea rows="4" cols="50" class="form-control" name="mycomments" id="mycomments"/></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-5 col-xs-offset-3">
                                    <button type="submit" class="btn btn-success">Αποθήκευση</button>
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer">
                            <p class="text-warning"><small>Εάν δεν γίνει αποθήκευση, όλες οι αλλαγές θα χαθούν.</small></p>
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal deleteuser-->
    <div id="deleteuser" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Επιλέξτε πελάτη για διαγραφή</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-modal-selecte">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Όνομα</th>
                              <th>Επώνυμο</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
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

                                $sqlget = "SELECT * FROM `diaitologos-pelatis` JOIN `pelatis` ON `diaitologos-pelatis`.`id-pelati`=`pelatis`.`id-pelati` WHERE `diaitologos-pelatis`.`id-diaitologou`='$connected_id'";
                                $sqldata = mysqli_query($con, $sqlget) or die('error getting date');


                                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                                    $idtodelete = $row['id-pelati'];
                                    $nametodelete = $row['onoma'];
                                    $lastnametodelete = $row['epitheto'];
                                    echo "<tr><td>";
                                    echo $row['id-pelati']; 
                                    echo "</td><td>";   
                                    echo $row['onoma'];
                                    echo "</td><td>";
                                    echo $row['epitheto'];
                                    echo "</td><td>";
                                    echo '<a href="#confirmation" type="submit" class="btn btn-default editButton" 
                                    data-dismiss="modal" data-toggle="modal" data-delete-id="'.$idtodelete.'" data-delete-name="'.$nametodelete.'" data-delete-lastname="'.$lastnametodelete.'">Διαγραφή</a>';
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                          </table>

                        <div class="modal-footer">
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmation-->
    <div id="confirmation" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Είστε σίγουρος πως θέλετε να προχωρήσετε;</h4>
                </div>
                <div class="modal-body">
                    <!-- The form which is used to populate the item data -->
                        <form id="userForm" method="post" class="form-horizontal" action="deleteuser.php">
                            <div class="form-group" style="display: none;">
                                <label class="col-xs-3 control-label">ID</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" name="myid" id="myid" readonly="" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="myname">Όνομα</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" name="myname" id="myname" readonly="" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="mylastname">Επίθετο</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" name="mylastname" id="mylastname" readonly=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-5 col-xs-offset-3">
                                    <button type="submit" class="btn btn-danger">Διαγραφή χρήστη</button>
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer">
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal createmeal-->
    <div id="createmeal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Επιλέξτε πελάτη για δημιουργία προγράμματος διατροφής.</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-modal-selecte">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Όνομα</th>
                              <th>Επώνυμο</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
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

                                $sqlget = "SELECT * FROM `diaitologos-pelatis` JOIN `pelatis` ON `diaitologos-pelatis`.`id-pelati`=`pelatis`.`id-pelati` WHERE `diaitologos-pelatis`.`id-diaitologou`='$connected_id'";
                                $sqldata = mysqli_query($con, $sqlget) or die('error getting date');


                                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                                    $idtopass = $row['id-pelati'];
                                    $nametopass = $row['onoma'];
                                    $lastnametopass = $row['epitheto'];
                                    $weighttopass = $row['baros'];
                                    $sextopass = $row['filo'];
                                    $agetopass = $row['ilikia'];
                                    $commentstopass = $row['sxolia'];
                                    echo "<tr><td>";
                                    echo $row['id-pelati']; 
                                    echo "</td><td>";   
                                    echo $row['onoma'];
                                    echo "</td><td>";
                                    echo $row['epitheto'];
                                    echo "</td><td>";
                                    echo '<a href="#finalmeal" type="submit" class="btn btn-default editButton" 
                                    data-dismiss="modal" data-toggle="modal" data-meal-id="'.$idtopass.'" data-meal-name="'.$nametopass.'" data-meal-lastname="'.$lastnametopass.'" data-meal-weight="'.$weighttopass.'" data-meal-sex="'.$sextopass.'" data-meal-age="'.$agetopass.'" data-meal-comments="'.$commentstopass.'">Δημιουργία</a>';
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                          </table>

                        <div class="modal-footer">
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal finalmeal-->
    <div id="finalmeal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Εισαγωγή νέου γεύματος</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method ="post" class="form-horizontal" action="createmeal.php">
                        <h4>Στοιχεία πελάτη</h4>
                        <div class="form-group" style="display: none;">
                            <label class="col-xs-3 control-label" for="myidpelati">Id πελάτη</label>
                            <div class="col-xs-2">
                            <input type="text" class="form-control" name="myidpelati" id="myidpelati" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myname">Όνομα</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="myname" id="myname" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mylastname">Επίθετο</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="mylastname" id="mylastname" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myweight">Βάρος</label>
                            <div class="col-xs-3">
                            <input type="number" class="form-control" name="myweight" id="myweight" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mysex">Φύλο</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="mysex" id="mysex" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myage">Ηλικία</label>
                            <div class="col-xs-3">
                            <input type="number" class="form-control" name="myage" id="myage" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mycomments">Σχόλια</label>
                            <div class="col-xs-8">
                            <textarea rows="4" cols="50" class="form-control" name="mycomments" id="mycomments" disabled></textarea>
                            </div>
                        </div>
                        <hr style="width: 100%; color: #2965A3; height: 1px; background-color:#2965A3;" />
                        <h4>Λεπτομέριες γεύματος</h4>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mydate">Ημερομηνία</label>
                            <div class="col-xs-4">
                            <input type="date" class="form-control" name="mydate" id="mydate" value="<?php echo date('d/m/y');?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mytype">Τύπος γεύματος</label>
                            <div class="col-xs-3">
                            <select mytype="Γεύμα" type="text" class="form-control" name="mytype" id="mytype">
                                <option value="1">1: Πρωινό</option>
                                <option value="2">2: Πρόγευμα</option>
                                <option value="3">3: Γεύμα</option>
                                <option value="4">4: Απογευματινό</option>
                                <option value="5">5: Δείπνο</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mymealcomments">Περιγραφή και σχόλια</label>
                            <div class="col-xs-8">
                            <textarea rows="4" cols="50" class="form-control" name="mymealcomments" id="mymealcomments" placeholder="Περιγραφή"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Αποθήκευση</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <p class="text-warning"><small>Εάν δεν γίνει αποθήκευση, όλες οι αλλαγές θα χαθούν.</small></p>
                    <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal report-->
    <div id="report" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Επιλέξτε πελάτη για προβολή του feedback του</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-modal-selecte">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Όνομα</th>
                              <th>Επώνυμο</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
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

                                $sqlget = "SELECT * FROM `diaitologos-pelatis` JOIN `pelatis` ON `diaitologos-pelatis`.`id-pelati`=`pelatis`.`id-pelati` WHERE `diaitologos-pelatis`.`id-diaitologou`='$connected_id'";
                                $sqldata = mysqli_query($con, $sqlget) or die('error getting date');


                                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                                    $idtopass = $row['id-pelati'];
                                    echo "<tr><td>";
                                    echo $row['id-pelati']; 
                                    echo "</td><td>";   
                                    echo $row['onoma'];
                                    echo "</td><td>";
                                    echo $row['epitheto'];
                                    echo "</td><td>";
                                    echo '<a href="#finalreport" type="submit" class="btn btn-default editButton" 
                                    data-dismiss="modal" data-toggle="modal" data-report-id="'.$idtopass.'">Προβολή</a>';
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                          </table>

                        <div class="modal-footer">
                            <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal finalreport-->
    <div id="finalreport" class="modal fade">
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Προβολή σχολίων πελάτη</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method ="post" class="form-horizontal" action="createmeal.php">
                        <div class="form-group" style="display: none;">
                            <label class="col-xs-3 control-label" for="myfeedbackid">Id πελάτη</label>
                            <div class="col-xs-2">
                            <input type="text" class="form-control" name="myfeedbackid" id="myfeedbackid" readonly="">
                            </div>
                        </div>
                        <h4>Επιλογή ημερομηνιών</h4>
                        <p class="text-warning"><small>Εάν δεν επιλεγούν ημερομηνίες, δεν εμφανίζεται το feedback.
                        Παρακαλώ επιλέξτε πρώτα την "Από" ημερομηνία.
                        Το refresh γίνεται αυτόματα μετά την επιλογή της "Έως" ημερομηνίας</small></p>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mystartdate">Από</label>
                            <div class="col-xs-4">
                            <input type="date" class="form-control" name="mystartdate" id="mystartdate" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="myenddate">Έως</label>
                            <div class="col-xs-4">
                            <input type="date" class="form-control" name="myenddate" id="myenddate" oninput="showTable()" required="">
                            </div>
                        </div>
                    </form>
                    <hr style="width: 100%; color: #2965A3; height: 1px; background-color:#2965A3;" />
                    <h4>Συγκεντρωτικά σχόλια</h4>
                    <div id="feedbacktable"></div>
                    <hr style="width: 100%; color: #2965A3; height: 1px; background-color:#2965A3;" />
                </div>

                <div class="modal-footer">
                    <a class = "btn btn-warning" data-dismiss = "modal">Κλείσιμο</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ================================================================== -->
                                <!-- End of Modals -->
    <!-- ================================================================== -->

    <!-- ================================================================== -->
        <!-- Scripts to pass values to my Modals fields where needed -->
    <!-- ================================================================== -->
    <script type="text/javascript">
        $('#finaledit').on('show.bs.modal', function(e) {
            var myid = $(e.relatedTarget).data('user-id');
            $(e.currentTarget).find('input[name="myid"]').val(myid);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var myname = $(e.relatedTarget).data('user-name');
            $(e.currentTarget).find('input[name="myname"]').val(myname);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var mylastname = $(e.relatedTarget).data('user-lastname');
            $(e.currentTarget).find('input[name="mylastname"]').val(mylastname);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var myweight = $(e.relatedTarget).data('user-weight');
            $(e.currentTarget).find('input[name="myweight"]').val(myweight);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var mysex = $(e.relatedTarget).data('user-sex');
            $(e.currentTarget).find('select[name="mysex"]').val(mysex);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var myage = $(e.relatedTarget).data('user-age');
            $(e.currentTarget).find('input[name="myage"]').val(myage);
        });
        $('#finaledit').on('show.bs.modal', function(e) {
            var mycomments = $(e.relatedTarget).data('user-comments');
            $(e.currentTarget).find('textarea[name="mycomments"]').val(mycomments);
        });




        $('#confirmation').on('show.bs.modal', function(e) {
            var myid = $(e.relatedTarget).data('delete-id');
            $(e.currentTarget).find('input[name="myid"]').val(myid);
        });
        $('#confirmation').on('show.bs.modal', function(e) {
            var myname = $(e.relatedTarget).data('delete-name');
            $(e.currentTarget).find('input[name="myname"]').val(myname);
        });
        $('#confirmation').on('show.bs.modal', function(e) {
            var mylastname = $(e.relatedTarget).data('delete-lastname');
            $(e.currentTarget).find('input[name="mylastname"]').val(mylastname);
        });




        $('#finalmeal').on('show.bs.modal', function(e) {
            var myidpelati = $(e.relatedTarget).data('meal-id');
            $(e.currentTarget).find('input[name="myidpelati"]').val(myidpelati);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var myname = $(e.relatedTarget).data('meal-name');
            $(e.currentTarget).find('input[name="myname"]').val(myname);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var mylastname = $(e.relatedTarget).data('meal-lastname');
            $(e.currentTarget).find('input[name="mylastname"]').val(mylastname);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var myweight = $(e.relatedTarget).data('meal-weight');
            $(e.currentTarget).find('input[name="myweight"]').val(myweight);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var mysex = $(e.relatedTarget).data('meal-sex');
            $(e.currentTarget).find('input[name="mysex"]').val(mysex);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var myage = $(e.relatedTarget).data('meal-age');
            $(e.currentTarget).find('input[name="myage"]').val(myage);
        });
        $('#finalmeal').on('show.bs.modal', function(e) {
            var mycomments = $(e.relatedTarget).data('meal-comments');
            $(e.currentTarget).find('textarea[name="mycomments"]').val(mycomments);
        });




        $('#finalreport').on('show.bs.modal', function(e) {
            var myfeedbackid = $(e.relatedTarget).data('report-id');
            $(e.currentTarget).find('input[name="myfeedbackid"]').val(myfeedbackid);
        });

    </script>
    <!-- ================================================================== -->
                        <!-- End of my Modals Scripts -->
    <!-- ================================================================== -->
    <!-- ================================================================== -->
                        <!-- My Scripts -->
    <!-- ================================================================== -->
    <script type="text/javascript">
        function xml_reminder()
        {
            var str="./xml_diatrofi.php";
            window.open(str);
        }
    </script>

    <script>
        function showTable() {
            var start = document.getElementById('mystartdate');
            var startdate = start.value;
            var end = document.getElementById('myenddate');
            var enddate = end.value;
            var idpelati = document.getElementById('myfeedbackid');
            var idpelati = idpelati.value;


            // replace '-' characters
            startdate = startdate.replace('-', '');
            startdate = startdate.replace('-', '');
            enddate = enddate.replace('-', '');
            enddate = enddate.replace('-', '');
            if (start == "" || end == "") {
                document.getElementById("feedbacktable").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("feedbacktable").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","getfeedback.php?q1="+startdate+"&q2="+enddate+"&q3="+idpelati,true);
                xmlhttp.send();
            }
        }
        </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
