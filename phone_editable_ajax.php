<?php

$id = $_POST['id'];
$phone = $_POST['value'];

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

$update_query = "UPDATE student_info SET phone='$phone' WHERE id='$id'";
$update_phone = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());
print_r($update_phone);

?>