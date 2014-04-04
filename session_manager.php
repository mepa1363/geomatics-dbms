<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['timeout']) || !isset($_SESSION['login_time']) || !isset($_SESSION['access_level'])) {
    header('Location: login.php');
}

$time = time();
if ($time - $_SESSION['login_time'] > $_SESSION['timeout']) {
    header('Location: logout.php');
}
