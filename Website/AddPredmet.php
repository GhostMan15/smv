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
    <link rel="stylesheet" href="Stylesheets/Predmet.css">
    <title>Ultis</title>
</head>
<body>
  
    <div class="Main1"> Dodajanje novega predmeta
    <div class="Main"> 
        <form action="" method="POST" >
            Naslov: <input class="text_field" type="text" name="naslov" value=""> <br><br>
            Kratica: <input class="text_field" type="text" name="kratica" value=""> <br><br>
            Opis: <input class="text_field" type="text" name="opis" value=""> <br><br>
            <input type="submit" name="submit" value="Ustvari">
        </form>
    </div>
    <div class="Main2"> <a href="class.php"><img src="Pictures/back.png" class="slika"></a> </div>
    </div>

    <?php 
        if (isset($_POST['submit'])) {
            
            $naslov = $_POST["naslov"];
            $opis = $_POST["opis"];
            $kratica = $_POST["kratica"];
            

            $query = "INSERT INTO `predmeti` VALUES(DEFAULT,'$naslov','$kratica','$opis');";      
            mysqli_query($db, $query);

            header("Location: AddPredmet.php");
        }
    ?>
    

   
    
</body>
</html>