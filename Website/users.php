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
    $user_type = $_SESSION["user_type"];
}
//check if user is admin, if not redirect to homepage
if ($user_type != "0") {
    header("location: home.php");
}
?>

<!DOCTYPE html>
<html>

<!--HEAD-->

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Mark Sadnik">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/users.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
    <title>Uporabniki</title>
</head>
<!--HEAD-->

<!--BODY-->

<body>
    <!--NAVBAR-->
    <div class="navbar_wrap">
        <div class="navbar">
            <?php
            //teachers
            if ($user_type == '1') {
                echo "
                <a href='home.php'><img src='Pictures/logo1.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='$$$'>Učenci</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //students
            else if ($user_type == '2') {
                echo "
                <a href='home.php'><img src='Pictures/logo2.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //admin
            else {
                echo "
                <a href='home.php'><img src='Pictures/logo.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li id='checked'> <a href='users.php'>Uporabniki</a></li>
                    <li> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            ?>
        </div>
    </div>
    <!--NAVBAR-->

    <!--CONTENT-->
    <div class="main">

    </div>
    <!--CONTENT-->
</body>
<!--BODY-->

</html>