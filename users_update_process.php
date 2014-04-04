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
    $id = $_POST['user_id'];
    $first_name = $_POST['user_first_name'];
    $last_name = $_POST['user_last_name'];
    $email = $_POST['user_email'];
    $username = $_POST['user_username'];
    $access_level = $_POST['user_access_level'];
    $password = md5($_POST['user_password1']);

    $update_query = "UPDATE user_info SET first_name='" . $first_name . "', last_name='" . $last_name .
        "', email='" . $email . "', username='" . $username . "', password='" . $password .
        "', access_level='" . $access_level . "' WHERE user_id='" . $id . "'";

    $update_member = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());

    $server_name = "http://" . $_SERVER['SERVER_NAME'] . ":8181";
    $current_dir = dirname($_SERVER['REQUEST_URI']) . "/";
    $url = $server_name . $current_dir . "users_dashboard.php";
    $header = "Location: " . $url;
    header($header);
}


?>