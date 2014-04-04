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
    $first_name = $_POST['user_first_name'];
    $last_name = $_POST['user_last_name'];
    $email = $_POST['user_email'];
    $username = $_POST['user_username'];
    $access_level = $_POST['user_access_level'];
    date_default_timezone_set('Canada/Mountain');
    $signup_date = date('Y-m-d H:i:s');

    $password = md5($_POST['user_password1']);
    $insert_query = "INSERT INTO user_info (first_name, last_name, email, signup_date, username, password, access_level)
    VALUES ('" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $signup_date . "', '" . $username . "', '" . $password .
        "', '" . $access_level . "')";

    $insert_member = mysql_query($insert_query) or die("SQL Error 1: " . mysql_error());

    $server_name = "http://" . $_SERVER['SERVER_NAME'] . ":8181";
    $current_dir = dirname($_SERVER['REQUEST_URI']) . "/";
    $url = $server_name . $current_dir . "users_dashboard.php";
    $header = "Location: " . $url;
    header($header);
}


?>