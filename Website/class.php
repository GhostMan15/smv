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
                $predmeti_query = "SELECT * FROM `predmeti`;";
                $predmeti_res = mysqli_query($db, $predmeti_query);
                $predmeti_num = mysqli_num_rows($predmeti_res);
                $i = 1;

                @$id = $_GET['id'];
                $moduli_query = "SELECT * FROM `model` WHERE `id_predmet` = '$id';";
                $moduli_res = mysqli_query($db, $moduli_query);


                echo"
                <div class='container'>
        <div class='asd'><a href='AddPredmet.php' class='plusek'>+</a></div> 
        <div class='Predmeti'>
        <table class='miza'> ";
        
        

           while($rows = mysqli_fetch_assoc($predmeti_res)){      //tuki se izpisejo vsi predmeti iz db
            if($predmeti_num > $i && $i != $predmeti_num)
            {
                 $i++;
                 
               echo" <tr><td> <a href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a></td></tr> ";
                
           }
                else{
                    
                  echo"  <tr><td> <a href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a></td></tr> <tr><td rowspan='1'></td></tr> ";
                }
           }
           
           
           

           
           if (isset($id)){
           {
            while($vrstice = mysqli_fetch_assoc($moduli_res)){
               echo" <tr><td> <a href='$$$'> $vrstice[Naslov] </a> </td></tr> ";
            }
           }
            
        } 
        echo"

           
        </table>
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
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                </div>
                </div>
                ";

                $predmeti_query = "SELECT * FROM `predmeti`;";
                $predmeti_res = mysqli_query($db, $predmeti_query);
                $predmeti_num = mysqli_num_rows($predmeti_res);
                $i = 1;

                @$id = $_GET['id'];
                $moduli_query = "SELECT * FROM `model` WHERE `id_predmet` = '$id';";
                $moduli_res = mysqli_query($db, $moduli_query);


                echo"
                <div class='container'>
        <div class='Predmeti'>
        <table class='miza'> ";
        
        

           while($rows = mysqli_fetch_assoc($predmeti_res)){      //tuki se izpisejo vsi predmeti iz db
            if($predmeti_num > $i && $i != $predmeti_num)
            {
                 $i++;
                 
               echo" <tr><td> <a href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a></td></tr> ";
                
           }
                else{
                    
                  echo"  <tr><td> <a href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a></td></tr> <tr><td rowspan='1'></td></tr> ";
                }
           }
           
           
           

           
           if (isset($id)){
           {
            while($vrstice = mysqli_fetch_assoc($moduli_res)){
               echo" <tr><td> <a href='$$$'> $vrstice[Naslov] </a> </td></tr> ";
            }
           }
            
        } 
        echo"

           
        </table>
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
                    <li> <a href='vp.php?id=".$id."'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
                </ul>
                </div>
                </div>";


                $predmeti_query = "SELECT * FROM `predmeti`;";
                $predmeti_res = mysqli_query($db, $predmeti_query);
                $predmeti_num = mysqli_num_rows($predmeti_res);
                $i = 1;

                @$id = $_GET['id'];
                $moduli_query = "SELECT * FROM `model` WHERE `id_predmet` = '$id';";
                $moduli_res = mysqli_query($db, $moduli_query);


                echo"
                <div class='container'>
        <div class='asd'><a href='AddPredmet.php' class='plusek'>+</a></div> 
        <div class='Predmeti'>
        <table class='miza'> ";
        
        

           while($rows = mysqli_fetch_assoc($predmeti_res)){      //tuki se izpisejo vsi predmeti iz db
            if($predmeti_num > $i && $i != $predmeti_num)
            {
                 $i++;
                 
               echo" <tr><td> <a class='HrefPredmetMain' href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a><a href='Scripts/delete.php?type=4&id=$rows[id_predmet]'><img src='Pictures/trash.png'  class='trashIcon' </a> </td> </tr> "; 
                
           }
                else{
                    
                  echo"  <tr><td> <a class='HrefPredmetMain' href='course.php?id=". $rows['id_predmet'] ."' target='__blank__'>". $rows['ime'] ."</a><a href='Scripts/delete.php?type=4&id=$rows[id_predmet]'><img src='Pictures/trash.png'  class='trashIcon' </a></td></tr> <tr><td rowspan='1'></td></tr> ";
                }
           }
           
           
           

           
           if (isset($id)){
           {
            while($vrstice = mysqli_fetch_assoc($moduli_res)){
               echo" <tr><td> <a href='$$$'> $vrstice[Naslov] </a> </td></tr> ";
            }
           }
            
        } 
        echo"

           
        </table>
        </div>
      </div>
                ";
            }
            ?>
        
    </div>
     
    
    
</body>
<!--BODY-->

</html>
