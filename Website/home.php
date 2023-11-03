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
    
    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $user_type =  $type_assoc['user_type'];
    $_SESSION["user_type"] = $user_type;
}

//display message from register.php, if there is one
if(isset($_SESSION["register_message"])){
    $msg = $_SESSION["register_message"];
    echo"<script>alert($msg);</script>";
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
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='users.php'>Učenci</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
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
                        <li><a href='redovalnica.php'>Ocene</a></li>
                        <li> <a href='vp.php'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
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
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                ";
            }
            ?>
        </div>

        <div class="content">
            <h1>Dobrodošli v Ultis</h1>
            <div id=tekst>Skupaj zmoremo!</div>
        </div>
    </div>
    <div class="FooterContent">
        <div class="Ikonca">
        <a href='home.php'><img src='Pictures/logo.png' class='Ikonca'></a>
        </div>
        <div class="FooterNav">
            <ul>
                <li><a href="">Domov</a></li>
                <li><a href="">O nas</a></li>
                <li><a href="">Stopite v stik</a></li>
            </ul>
        </div>

    </div>

</body>

</html>