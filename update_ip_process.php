<?php
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

//This code runs if the form has been submitted
if (isset($_POST['submit'])) {
    $id = $_POST['ip_id'];
    $ip = $_POST['ip_address'];
    $desc = $_POST['ip_desc'];
    $update_query = "UPDATE ip_info SET ip_address='" . $ip . "', description='" . $desc . "' WHERE id='" . $id . "'";
    $update_member = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());

    $server_name = "http://" . $_SERVER['SERVER_NAME'] . ":8181";
    $current_dir = dirname($_SERVER['REQUEST_URI']) . "/";
    $url = $server_name . $current_dir . "ip_settings.php";
    $header = "Location: " . $url;
    header($header);
}


?>