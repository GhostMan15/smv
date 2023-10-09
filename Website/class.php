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

<!--HEAD-->

<head>
    <meta name="author" content="Mark Sadnik">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Stylesheets/class.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
    <title>Predmeti</title>
</head>
<!--HEAD-->

<!--BODY-->

<body>
    <div class="bannerr">
        
    <?php
            //teachers
            if ($user_type == '1') {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                <a href='homepage.html'><img src='Pictures/logo1.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li id='checked'> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='users.php'>Učenci</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                </div>
                </div>
                ";
            }
            //students
            else if ($user_type == '2') {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                <a href='homepage.html'><img src='Pictures/logo2.png' class='logo'></a>
                <ul>
                    <li><a href='home.php'>Domov</a></li>
                    <li id='checked'> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                </div>
                </div>
                ";
            }
            //admin
            else {
                echo "<div class='navbar_div'> <div class = 'navbar'>
                <a href='homepage.html'><img src='Pictures/logo0.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li id='checked'> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='users.php'>Uporabniki</a></li>
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                </div>
                </div>
                ";
            }
            ?>
        <div class="slikicaDIV"> <img class="slikica" id="slikaID"> </div>
        <div class="Predmeti">
        <table class="miza">
        <?php  
           $predmeti_query = "SELECT * FROM `predmeti`;";
           $predmeti_res = mysqli_query($db, $predmeti_query);
       
           

           while($rows = mysqli_fetch_assoc($predmeti_res)){
            echo" 
            <tr class='miza'><td> <a href='class.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a> <td><tr>
            ";
           }
           ?>
        </table>
        </div>
      </div>
     
    
    
</body>
<!--BODY-->
<script>
    var t = 0;
        while(true){
            t = Math.floor(Math.random() * 4);
            if(t != 0){
                break;
            }
        }
            document.getElementById('slikaID').src = 'Pictures/quot' + t + '.png';
            
                
</script>
</html>