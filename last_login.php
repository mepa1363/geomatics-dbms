<?php
include('session_manager.php');
include('db_connect.php');
$connect = mysql_connect($hostname, $username, $password)
or die('Could not connect: ' . mysql_error());
$bool = mysql_select_db($database, $connect);
if ($bool === False) {
    print "can't find $database";
}
$id = $_SESSION['user_id'];
date_default_timezone_set('Canada/Mountain');
$last_login = date('Y-m-d H:i:s');
$update_last_login_query = "UPDATE user_info SET last_login='" . $last_login . "' WHERE user_id=" . $id;
$update_exec = mysql_query($update_last_login_query) or die("SQL Error 1: " . mysql_error());

header('Location: student_dashboard.php');