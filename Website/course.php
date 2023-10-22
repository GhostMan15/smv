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
    <meta name="author" content="Žan Šuperger">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/style.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/class.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/course.css">
    <title>Ultis</title>
</head>
<body>
<div>
        
        <?php
                //teachers
                if ($user_type == '1') {
                    echo "<div class='navbar_div'> <div class = 'navbar'>
                    <a href='index.html'><img src='Pictures/logo1.png' class='logo'></a>
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

                    $id = $_GET['id'];
                    $predmeti_query =  "SELECT * FROM `predmeti` WHERE `id_predmet` = '$id';";
                    $predmeti_res = mysqli_query($db, $predmeti_query);
                    $predmet = mysqli_fetch_assoc($predmeti_res);
    
                    $model_query = "SELECT * FROM `model` WHERE  `id_predmet` = '$id';";
                    $model_res = mysqli_query($db, $model_query);
                    
                    
             echo" <div class='vsebina'>
                    <div class='vsebina-naslov'>". $predmet['ime'] ."<br>  <!--PREDMET-->
                     </div>
                     <div class='vsebina-poglavje'>            <!--MODEL-->";
                            
                     while($rows = mysqli_fetch_assoc($model_res)){      
                        
                    
                        echo"<a href = '' class='vsebina-poglavje1'>$rows[Naslov] </a> <br>";
                        echo"<div class='asd'><a href=AddVaja.php?id_predmet='$id'<p class='plusek'> + </p></a></div> ";
    
    
                        $grad_query = "SELECT * FROM `gradiva` WHERE  `id_modula` = '$rows[id_modula]';";
                        $grad_res = mysqli_query($db, $grad_query);
                        $grad_num = mysqli_num_rows($grad_res);
                        $g = 1;
    
    
                        while ($rowss = mysqli_fetch_assoc($grad_res)){
                          echo" <div class='gradivo'> 
                          <div class='gradivo-item'><a href='material.php?gradivo=$rowss[id_gradiva]'> $rowss[naslov] </a> </div>
                          </div>";
                          if ($g >= $grad_num){
                            echo"<hr>";
                          }
                          $g++;
                        }   
                       }
                        
                    }
                
                //students
                else if ($user_type == '2') {
                    echo "<div class='navbar_div'> <div class = 'navbar'>
                    <a href='index.html'><img src='Pictures/logo2.png' class='logo'></a>
                    <ul>
                        <li><a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
                    </ul>
                    </div>
                    </div>
                    ";
                            
                $id = $_GET['id'];
                $predmeti_query =  "SELECT * FROM `predmeti` WHERE `id_predmet` = '$id';";
                $predmeti_res = mysqli_query($db, $predmeti_query);
                $predmet = mysqli_fetch_assoc($predmeti_res);

                $model_query = "SELECT * FROM `model` WHERE  `id_predmet` = '$id';";
                $model_res = mysqli_query($db, $model_query);
                

         echo" <div class='vsebina'>
                <div class='vsebina-naslov'>". $predmet['ime'] ."<br>  <!--PREDMET-->
                 </div>
                 <div class='vsebina-poglavje'>             <!--MODEL-->";
                        
                 while($rows = mysqli_fetch_assoc($model_res)){      
                    
                    echo"<a href = '' class='vsebina-poglavje1'>$rows[Naslov] </a> <br>";


                    $grad_query = "SELECT * FROM `gradiva` WHERE  `id_modula` = '$rows[id_modula]';";
                    $grad_res = mysqli_query($db, $grad_query);
                    $grad_num = mysqli_num_rows($grad_res);
                    $g = 1;


                    while ($rowss = mysqli_fetch_assoc($grad_res)){
                      echo" <div class='gradivo'> 
                      <div class='gradivo-item'><a href='material.php?gradivo=$rowss[id_gradiva]'> $rowss[naslov] </a> </div>
                      </div>";
                      if ($g >= $grad_num){
                        echo"<hr>";
                      }
                      $g++;
                    }   
                   }   
    
                }
                //admin
                else {
                    echo "<div class='navbar_div'> <div class = 'navbar'>
                    <a href='index.html'><img src='Pictures/logo0.png' class='logo'></a>
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

                $id = $_GET['id'];
                $predmeti_query =  "SELECT * FROM `predmeti` WHERE `id_predmet` = '$id';";
                $predmeti_res = mysqli_query($db, $predmeti_query);
                $predmet = mysqli_fetch_assoc($predmeti_res);
                

                $model_query = "SELECT * FROM `model` WHERE  `id_predmet` = '$id';";
                $model_res = mysqli_query($db, $model_query);
                

         echo" <div class='vsebina'>
                <div class='vsebina-naslov'>". $predmet['ime'] ."<br>  <!--PREDMET-->
                 </div>
                 <div class='vsebina-poglavje'>            <!--MODEL-->";
                        
                 while($rows = mysqli_fetch_assoc($model_res)){      
                    $idmod = $rows['id_modula'];
                    echo"<a href = '' class='vsebina-poglavje1'>$rows[Naslov] </a> <br>";
                    echo"<div class='asd'><a href=AddVaja.php?id_predmet=$id&id_modula=$idmod><p class='plusek'> + </p></a></div> ";
                    


                    $grad_query = "SELECT * FROM `gradiva` WHERE  `id_modula` = '$rows[id_modula]';";
                    $grad_res = mysqli_query($db, $grad_query);
                    $grad_num = mysqli_num_rows($grad_res);
                    $g = 1;


                    while ($rowss = mysqli_fetch_assoc($grad_res)){
                      echo" <div class='gradivo'> 
                      <div class='gradivo-item'><a href='material.php?gradivo=$rowss[id_gradiva]'> $rowss[naslov] </a> </div>
                      </div>";
                      if ($g >= $grad_num){
                        echo"<hr>";
                      }
                      $g++;
                    }   
                   }
                    
                }
                ?>

</body>
</html>
