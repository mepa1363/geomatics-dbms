<?php
include('session_manager.php');
include('gatekeeper.php');
if (viewer_gatekeeper()) {
    header('Location: student_dashboard.php');
}

#Include the connect.php file
include('db_connect.php');
#Connect to the database
//connection String
$connect = mysql_connect($hostname, $username, $password)
    or die('Could not connect: ' . mysql_error());
//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False) {
    print "can't find $database";
}
//retrieve students info
$delete_query = "DELETE FROM student_info WHERE id='" . $_POST['student_id'] . "'";

$query_result = mysql_query($delete_query) or die("SQL Error 1: " . mysql_error());
print_r($query_result);
