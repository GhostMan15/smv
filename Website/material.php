<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

if (!isset($_SESSION["id"], $_SESSION["username"], $_SESSION["user_type"], $_SESSION['pass'])) {
    header("location: login.php");
}

//if the user is logged in, allow access
else {
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];

    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $pass = $_SESSION['pass'];
    $user_type = $type_assoc['user_type'];
    $_SESSION["user_type"] = $user_type;
}
?>

<!DOCTYPE html>
<html>
<!--HEAD-->

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Gradivo</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/material.css">
    <link rel="stylehseet" type="text/css" href="Stylesheets/navbar.css">
</head>
<!--HEAD-->

<body>
    <div class="bannerVP">
        <div class="navbar">
            <?php
            //teachers
            if ($user_type == '1') {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                        <a href='index.html'><img src='Pictures/logo1.png' class='logo'></a>
                        <ul>
                            <li> <a href='home.php'>Domov</a></li>
                            <li id='checked'> <a href='class.php'>Predmeti</a></li>
                            <li> <a href='users.php'>Učenci</a></li>
                            <li> <a href='vp.php?id=" . $id . "'>Vaš Profil</a></li>
                            <li> <a href='Scripts/logout.php'>Odjava</a></li>
                        </ul>
                        </div>
                        </div>
                        ";
            }
            //students
            else if ($user_type == '2') {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                        <a href='index.html'><img src='Pictures/logo2.png' class='logo'></a>
                        <ul>
                            <li><a href='home.php'>Domov</a></li>
                            <li id='checked'> <a href='class.php'>Predmeti</a></li>
                            <li> <a href='vp.php?id=" . $id . "'>Vaš Profil</a></li>
                            <li> <a href='Scripts/logout.php'>Odjava</a></li>
                        </ul>
                        </div>
                        </div>
                        ";
            }
            //admin
            else {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                        <a href='index.html'><img src='Pictures/logo0.png' class='logo'></a>
                        <ul>
                            <li> <a href='home.php'>Domov</a></li>
                            <li id='checked'> <a href='class.php'>Predmeti</a></li>
                            <li> <a href='users.php'>Uporabniki</a></li>
                            <li> <a href='vp.php?id=" . $id . "'>Vaš Profil</a></li>
                            <li> <a href='Scripts/logout.php'>Odjava</a></li>
                        </ul>
                        </div>
                        </div>
                        ";
            }
            ?>
        </div>
    </div>
</body>

</html>