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
<html lang="en">
<!--HEAD-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradivo</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/material.css">
</head>
<!--HEAD-->

<body>

    <!--MAIN-->
    <div class="main">

        <!--NAV-->
        <div class="navbar_div">
            <div class="navbar">
            <?php

                //teachers
                if ($user_type == 1) {
                    echo "
                    <a href='home.php'><img src='Pictures/logo1.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li> <a href='users.php'>Učenci</a></li>
                        <li> <a href='vp.php'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
                    </ul>
                    ";
                }
                //students
                else if ($user_type == 2) {
                    echo "
                    <a href='home.php'><img src='Pictures/logo2.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li> <a href='vp.php'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
                    </ul>
                    ";
                }
                //admin
                else if ($user_type == 0){
                    echo "
                    <a href='home.php'><img src='Pictures/logo0.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li> <a href='users.php'>Uporabniki</a></li>
                        <li> <a href='vp.php'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
                    </ul>
                    ";
                }    
            ?>    
            </div>
        </div>
        <!--NAV-->

        <!--CONTAINER-->
        <form class="container">
            <div class="content">
                
                <!--TOP-->        
                <div class="top">
                    <div class="title_con">
                        <input type="text" name="title" class="title" value='Naloga1' required maxlength="50">
                    </div>
                </div>
                <!--TOP-->

                <!--MID-->
                <div class="mid">
                    <div class="text_con">
                        <textarea maxlength="1024" name="description" required>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ex elit, facilisis a magna sed, malesuada euismod velit. Donec massa sapien, elementum eu justo eget, maximus viverra diam. Quisque egestas viverra elit, sed posuere urna cursus id. Phasellus vel rutrum neque. Fusce tincidunt ornare lacus ac semper. Nunc lacinia, felis eu placerat mattis, turpis lorem ultrices lorem, a pulvinar lorem mi sit amet lacus. Fusce tincidunt libero vitae facilisis pretium. Nulla mollis sit amet metus vel gravida.
                        Integer non risus vitae ante tincidunt iaculis vel sit amet neque. In hac habitasse platea dictumst. Quisque molestie, odio a viverra sollicitudin, massa.
                        </textarea>
                    </div>
                </div>
                <!--MID-->

                <!--BOTTOM-->
                <div class="bottom">

                </div>
                <!--BOTTOM-->
            </div>
        </form>
        <!--CONTAINER-->

    </div>
    <!--MAIN-->

</body>

</html>