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


$username = trim(strtolower($_POST['username']));
$username = mysql_real_escape_string($username);

$query = "SELECT username FROM user_info WHERE username = '$username' LIMIT 1";
$result = mysql_query($query);
$num = mysql_num_rows($result);

echo $num;
mysql_close($connect);
