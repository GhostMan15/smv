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
$id_predmeta = $_GET['id_predmet'];
$query = "SELECT * FROM `predmeti` WHERE `id_predmet` = $id_predmeta;";
$query_res = mysqli_query($db, $query);
$predmet = mysqli_fetch_assoc($query_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/Predmet.css">
    <title>Ultis</title>
</head>
<body>
<div class="Main1"> Dodajanje novega Modula v predmet <?php echo"$predmet[ime]"; ?>
    <div class="Main"> 
        <form action="" method="POST" >
            Naslov: <input type="text" name="naslov" value=""> <br><br>
            Opis: <input type="text" name="opis" value="">
            <input type="submit" name="submit" value="Ustvari">
        </form>
    </div>
    <div class="Main2"> <a href="class.php"><img src="Pictures/back.png" class="slika"></a> </div>
    </div>

    <?php 
        if (isset($_POST['submit'])) {
            
            $ime = $_POST["naslov"];
            $opis = $_POST["opis"];
            
            $query_insert = "INSERT INTO `model` VALUES(DEFAULT,'$id_predmeta','$ime','$opis');";      
            mysqli_query($db, $query_insert);

            header("Location: class.php");
        }
    ?>
</body>
</html>