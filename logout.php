<?php
session_start();
unset($_SESSION["login_user"]);
unset($_SESSION["login_id"]);
session_destroy();
echo 'Αποσυνδεθήκατε επιτυχώς! Redirecting....';
header('Refresh: 3; URL = index.php');
?>