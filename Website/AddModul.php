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
    <form action="" class='Main' method="POST" class="form">
        <!--GLAVNI NASLOV-->
        <div class="title">
            Dodajanje novega Modula v predmet <b><?php echo "$predmet[ime]"; ?></b>
        </div>
        <!--NASLOV-->
        <div>
            Naslov:
        </div>
        <div>
            <input type="text" class='text_field' name="naslov" value="" required>
        </div>
        <!--NASLOV-->

        <!--OPIS-->
        <div>
            Opis:
        </div>
        <div>
            <input type="text" class='text_field' name="opis" value="" required>
        </div>
        <!--OPIS-->

        <!--SUBMIT-->
        <div class="submit_con">
            <div>
                <a href="class.php"><img src="Pictures/back.png" class="slika"></a>
            </div>
            <div>
                <input type="submit" class="submit_btn" name="submit" value="Ustvari">
            </div>
        </div>
        <!--SUBMIT-->

        <!--BACK-->
        <div>

        </div>
        <!--BACK-->
    </form>

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