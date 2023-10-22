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
         $pageRefresh = 

         $mod = $_GET['id_modula'];
         $id = $_GET['id_predmet'];
         
         $predmeti_query =  "SELECT * FROM `predmeti` WHERE `id_predmet` = $id;";
         $predmeti_res = mysqli_query($db, $predmeti_query);
         $predmet = mysqli_fetch_assoc($predmeti_res);
         $keroPoglavje = "SELECT * FROM `model` WHERE `id_modula` = $mod;";
         $keroPoglavje_res = mysqli_query($db, $keroPoglavje);
         $poglavje = mysqli_fetch_assoc($keroPoglavje_res);

        
    ?>
    <div class="Main1"> Dodajanje nove vaje v <?php echo $poglavje['Naslov']; ?>
    <div class="Main"> 
        <form action="" method="POST" >
            Naslov: <input type="text" name="naslov" value=""> <br><br>
            Opis: <input type="text" name="opis" value=""> <br><br>
            <input type="submit" name="submit" value="Ustvari">
        </form>
    </div>
    <div class="Main2"> <a href="class.php"><img src="Pictures/back.png" class="slika"></a> </div>
    </div>

    <?php 
        if (isset($_POST['submit'])) {
            
            $ime = $_POST['naslov'];
            $opis = $_POST['opis'];

            $query = "INSERT INTO `gradiva` VALUES(DEFAULT,'',NULL,'','$ime','$opis','$mod');";      
            mysqli_query($db, $query);

            header("Location: AddVaja.php?id_predmet=$id&id_modula=$mod");
        }
    ?>
    

   
    
</body>
</html>