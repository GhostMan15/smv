<?php
include('Scripts/config.php');
//START THE SESSION
session_start();

if (!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['user_type'], $_SESSION['pass'])) {
    header('location: login.php');
}
?>