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
    $ip = $_POST['ip_address'];
    $description = $_POST['ip_desc'];
    $insert_query = "INSERT INTO ip_info (ip_address, description) VALUES ('" . $ip . "', '" . $description . "')";
    $add_member = mysql_query($insert_query) or die("SQL Error 1: " . mysql_error());
    //print_r($name);
    //print_r($insert_query);
    //print_r($add_member);
    $server_name = "http://" . $_SERVER['SERVER_NAME'] . ":8181";
    $current_dir = dirname($_SERVER['REQUEST_URI']) . "/";
    $url = $server_name . $current_dir . "ip_settings.php";
    $header = "Location: " . $url;
    header($header);
}


?>