<?php
session_start();
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

$username = $_POST['username'];
$_password = md5($_POST['password']);

$result = mysql_query("SELECT * FROM user_info WHERE username='$username' AND password='$_password'")or die(mysql_error());
$num_row = mysql_num_rows($result);
$row = mysql_fetch_array($result);
if ($num_row >= 1) {
    echo '1';
    $_SESSION['user_name'] = $row['username'];
    $_SESSION['access_level'] = $row['access_level'];
    $_SESSION['login_time'] = time();
    $_SESSION['timeout'] = 3600;
    $_SESSION['user_id'] = $row['user_id'];
} else {
    echo '0';
}

?>

