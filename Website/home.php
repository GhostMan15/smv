<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

//if the user isn't logged in / session variables aren't set, redirect to login
if (!isset($_SESSION["id"], $_SESSION["username"], $_SESSION["user_type"])) {
    header("location: login.php");
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
    <meta name="author" content="Žan Šuperger">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/style.css">
    <title>Ultis</title>
</head>

<body>

    <div class="banner">
        <div class="navbar">
            <?php
            //teachers
            if ($user_type == '1') {
                echo "
                <a href='home.php'><img src='Pictures/logo1.png' class='logo'></a>
                <ul>
                    <li id='checked'> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='$$$'>Učenci</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //students
            else if ($user_type == '2') {
                echo "
                <a href='home.php'><img src='Pictures/logo2.png' class='logo'></a>
                <ul>
                    <li id='checked'><a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //admin
            else {
                echo "
                <a href='home.php'><img src='Pictures/logo0.png' class='logo'></a>
                <ul>
                    <li id='checked'> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='users.php'>Uporabniki</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            ?>
            <!--
            <ul>
                <li> <a href="$$$">Domov</a></li>
                <li> <a href="$$$">Moduli</a></li>
                <li> <a href="$$$">Predmeti</a></li>
                <li> <a href="$$$">Vaš Profil</a></li>
                <li> <a href="login.php">Odjava</a></li>
            </ul>
            -->
        </div>

        <div class="content">
            <h1>Dobrodošli v Ultis</h1>
            <div id=tekst>Skupaj zmoremo!</div>
        </div>
    </div>

</body>

</html>