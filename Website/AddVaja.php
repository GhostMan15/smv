<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

//if the user isn't logged in / session variables aren't set, redirect to login
if (!isset($_SESSION["id"], $_SESSION["username"], $_SESSION["user_type"])) {
    header("location: Scripts/logout.php");
}
//if the user is logged in, allow access
else {
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    $user_type =  $_SESSION["user_type"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/AddVaja.css">
    <title>Document</title>
</head>
<body>
    <?php
         $id = $_GET['id_predmet'];
        
         $predmeti_query =  "SELECT * FROM `predmeti` WHERE `id_predmet` = $id;";
         $predmeti_res = mysqli_query($db, $predmeti_query);
         $predmet = mysqli_fetch_assoc($predmeti_res);



    ?>
    
</body>
</html>