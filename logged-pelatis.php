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

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="favicon.ico">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link href="css/responsive-calendar.css" rel="stylesheet">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

        <script>
        function showTable(str) {
            if (str == "") {
                document.getElementById("mealtable").innerHTML = "";
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
                        document.getElementById("mealtable").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","getmeal.php?q="+str,true);
                xmlhttp.send();
            }
        }
        </script>

        <!-- On page load show meals of today to our client -->
        <script type="text/javascript">
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

        today = yyyy+mm+dd;
        window.onload = showTable(today);
        </script>
    </head>
    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand">Εφαρμογή διαχείρισης σωματικού βάρους</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" role="form" method ="post" action="logout.php">
                <button type="submit" name="Submit" class="btn btn-success">Έξοδος</button>
            </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Ημερολόγιο</h2>
          <!-- Responsive calendar - START -->
          <div class="responsive-calendar" style="border-radius: 10px;">
            <div class="controls">
                <a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
                <h4><span data-head-year></span> <span data-head-month></span></h4>
                <a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
            </div><hr/>
            <div class="day-headers">
              <div class="day header">Δευ</div>
              <div class="day header">Τρι</div>
              <div class="day header">Τετ</div>
              <div class="day header">Πεμ</div>
              <div class="day header">Παρ</div>
              <div class="day header">Σαβ</div>
              <div class="day header">Κυρ</div>
            </div>
            <div class="days" data-group="days">
              
            </div>
          </div>
          <!-- Responsive calendar - END -->
        </div>
        <div class="col-md-8">
            <h2>Πρόγραμμα διατροφής</h2>
            <p><strong>Διαλέξτε ημέρα, για να δείτε τα γεύματα που σας έχει ορίσει ο διαιτολόγος.</strong></p>
            <div id="mealtable"></div>
            <a href="#dayfeedback" type="submit" class="btn btn-info editButton" data-toggle="modal">Προσθήκη σχολίου ημέρας</a>
            <p class="text-warning"><small>Επιλέξτε εδώ για να προσθέσετε το συγκεντρωτικό feedback ημέρας.</small></p>
       </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Αθανάσιος Φανός 3η εργασία ΠΛΗ23 2016</p>
      </footer>
    </div> <!-- /container -->

    <!-- ================================================================== -->
                                <!-- My Modals -->
    <!-- ================================================================== -->
    <!-- Modal mealedit-->
    <div id="mealedit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ενημέρωση λεπτομερειών γεύματος</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method ="post" class="form-horizontal" action="editmeals.php">
                        <div class="form-group" style="display: none;">
                            <label class="col-xs-3 control-label" for="mealid">Id Γεύματος</label>
                            <div class="col-xs-3">
                            <input type="text" class="form-control" name="mealid" id="mealid" readonly="">
                            </div>
                        </div>
                        <p class="text-warning"><small>Εάν το γεύμα δεν καταναλώθηκε, αφήστε κενή την ώρα.</small></p>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mytime">Ώρα κατανάλωσης</label>
                            <div class="col-xs-3">
                            <input type="time" class="form-control" name="mytime" id="mytime">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="mycomments">*Σχόλια</label>
                            <div class="col-xs-6">
                            <textarea rows="4" cols="50" class="form-control" name="mycomments" id="mycomments" placeholder="Το feedback σας"></textarea>
                            <p>*προαιρετικό πεδίο</p>
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

    <!-- Modal dayfeedback-->
    <div id="dayfeedback" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Συγκεντρωτικό σχόλιο ημέρας</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method ="post" class="form-horizontal" action="dayfeedback.php">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="feedbackdate">Ημερομηνία</label>
                            <div class="col-xs-4">
                            <input type="date" class="form-control" name="feedbackdate" id="feedbackdate" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="feedbackcomments">Σχόλια</label>
                            <div class="col-xs-8">
                            <textarea rows="4" cols="50" class="form-control" name="feedbackcomments" id="feedbackcomments" placeholder="Σχόλια" required=""></textarea>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/responsive-calendar.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // add a zero (0) at the start of month or date in case of single digit
            function addLeadingZero(num) {
                if (num < 10) {
                  return "0" + num;
                } else {
                  return "" + num;
                }
              }
            //call function to create callendar
            $(".responsive-calendar").responsiveCalendar({
                translateMonths: ["Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος"],
                // set current month to preview in our calendar
                time: '<?php echo date("Y-m"); ?>',
                events: {
                    // show current day (today) in calendar
                    <?php echo '"'.date("Y-m-d").'": {}},'; ?>
                //when you click a date
                onDayClick: function(events) {   
                    var datefield;
                    datefield = $(this).data('year')+addLeadingZero( $(this).data('month') )+addLeadingZero( $(this).data('day'));
                    //call this function (with the date clicked) in order to show meals
                    showTable(datefield)
                }
            });
      });
    </script>
    <!-- ================================================================== -->
        <!-- Scripts to pass values to my Modals fields where needed -->
    <!-- ================================================================== -->
    <script type="text/javascript">
        $('#mealedit').on('show.bs.modal', function(e) {
            var mealid = $(e.relatedTarget).data('meal-id');
            $(e.currentTarget).find('input[name="mealid"]').val(mealid);
        });
        $('#mealedit').on('show.bs.modal', function(e) {
            var mytime = $(e.relatedTarget).data('meal-time');
            $(e.currentTarget).find('input[name="mytime"]').val(mytime);
        });        
    </script>
    <!-- ================================================================== -->
                        <!-- End of my Modals Scripts -->
    <!-- ================================================================== -->
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    </body>
</html>
