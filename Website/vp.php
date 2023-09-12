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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaš profil</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/vp.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
</head>

<body>

    <div class="bannerVP">
        <div class="navbar">
            <a href="homepage.html"><img src="Pictures/logo2.png" class="logo"></a>
            <ul>
                <li> <a href="home.php">Domov</a></li>
                <li> <a href="$$$">Moduli</a></li>
                <li> <a href="$$$">Predmeti</a></li>
                <li> <a href="vp.php">Vaš Profil</a></li>
                <li> <a href="login.php">Odjava</a></li>
            </ul>
        </div>

        <div class="contentVP">
            <h1>Vaš Profil</h1>
            
            <br>

            <div class="user_info">
                <div class="name">
                    
                </div>
                <div class="password">

                </div>
                <div class="about">

                </div>
                <div class="">

                </div>
                <div>

                </div>
            </div>
            Ime: xxx <img src="Pictures/edit.png" class="edit"></img><br><br>
            Password: *** <img src="Pictures/edit.png" class="edit"></img><br><br>
            O meni: <img src="Pictures/edit.png" class="edit"></img><br><br>
            sngojgsdkogjoghjgldhkg
        </div>


    </div>

</body>

</html>