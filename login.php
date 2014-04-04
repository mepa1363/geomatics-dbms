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

$remote_ip = $_SERVER['REMOTE_ADDR'];
$remote_ip = GetHostByName($remote_ip);

$query = "SELECT ip_address FROM ip_info WHERE ip_address='$remote_ip'";
$result = mysql_query($query) or die(mysql_error());
$check = mysql_num_rows($result);

if ($check != 0) {
    if (isset($_SESSION['user_name']) || isset($_SESSION['timeout']) || isset($_SESSION['login_time'])) {
        header('Location: student_dashboard.php');
    }
} else {
    header('Location: limited_access.php');
}
?>


<!DOCTYPE html>

<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login_style.css"/>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#submit").click(function () {

                var username = $("#username").val();
                var password = $("#password").val();
                $.ajax({
                    type: "POST",
                    url: "login_process.php",
                    data: "username=" + username + "&password=" + password,
                    success: function (response) {
                        if (response == 1) {
                            //alert('successful');
                            window.location.href = 'last_login.php';
                        }
                        else if (response == 0) {
                            //$("#add_err").html("Wrong username or password");
                            alert('Wrong username or password!');
                        }
                    },
                    beforeSend: function () {
                        //$("#add_err").html("Loading...")
                    }
                });
                return false;
            });
        });
    </script>
</head>
<body>
<div class="container">
    <section id="content">
        <div style="position:relative; top: -5px;">
            <img src="images/ucalgary3.png" style="width: 80px;position: relative; float: left;margin-left: 25px;"/>
            <img src="images/geoamtics3.png"
                 style="width: 70px; position: relative; float: right; margin-right: 30px; margin-top: 5px;"/>
        </div>
        <form action="" method="post">

            <h1>Graduate Students Portal</h1>

            <div style="margin-top: 20px;">
                <input type="text" name="username" placeholder="Username" required="required" id="username"/>
                <input type="password" name="password" placeholder="Password" required="required" id="password"/>
            </div>
            <div style="margin-left:auto;margin-right:auto;width:50%;">
                <input type="submit" id="submit" name="submit" value="Login"/>
            </div>

        </form>
        <!-- form -->

        <div class="button">
            <a href="http://www.geomatics.ucalgary.ca/" target="_blank">&copy; Department of Geomatics Engineering,
                2012</a>
        </div>
        <!-- button -->
    </section>
    <!-- content -->
</div>
<!-- container -->

</body>
</html>

