<?php
session_start();
unset($_SESSION['user_name']);
unset($_SESSION['timeout']);
unset($_SESSION['login_time']);
session_destroy();
header('Location: login.php');
?>