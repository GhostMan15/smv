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
      echo "
      <div class='navbar_div'> 
        <div class = 'navbar'>
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

      $predmeti_query = "SELECT DISTINCT `p`.* 
      FROM `predmeti` `p` JOIN `ucilnica` `u`
        ON `p`.`id_predmet` = `u`.`id_predmet`
      WHERE `u`.`id_user` = '$id';
      ";
      $predmeti_res = mysqli_query($db, $predmeti_query);
      $predmeti_num = mysqli_num_rows($predmeti_res);
      $i = 1;

      echo "
        <div class='container'>
          <div class='kontainer'>
              <div><p class='title'>Moji predmeti</p></div>
          </div>
          <div class='Predmeti'>
            <table class='miza'> 
      ";

      //tuki se izpisejo vsi predmeti iz db
      if($predmeti_num > 0){
        while ($rows = mysqli_fetch_assoc($predmeti_res)) {      
          if ($predmeti_num > $i && $i != $predmeti_num) {
            $i++;
  
            echo " <tr><td> <a href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a></td></tr> ";
          } else {
  
            echo "  <tr><td> <a href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a></td></tr> <tr><td rowspan='1'></td></tr> ";
          }
        }
      }

      else{
        echo"
        <tr>
          <td>Trenutno še ne učite nobenega predmeta</td>
        </tr>
        ";
      }

      echo "
            </table>
          </div>
        </div>
        ";
    }

    //students
    else if ($user_type == '2') {
      echo "
      <div class='navbar_div'> 
        <div class = 'navbar'>
          <a href='home.php'><img src='Pictures/logo2.png' class='logo'></a>
          <ul>
            <li> <a href='home.php'>Domov</a></li>
            <li id='checked'> <a href='class.php'>Predmeti</a></li>
            <li> <a href='redovalnica.php'>Ocene</a></li>
            <li> <a href='vp.php'>Vaš Profil</a></li>
            <li> <a href='Scripts/logout.php'>Odjava</a></li>
          </ul>
        </div>
      </div>
      ";

      $predmeti_query = "SELECT DISTINCT `p`.* 
      FROM `predmeti` `p` JOIN `ucilnica` `u`
        ON `p`.`id_predmet` = `u`.`id_predmet`
      WHERE `u`.`id_user` = '$id';
      ";
      $predmeti_res = mysqli_query($db, $predmeti_query);
      $predmeti_num = mysqli_num_rows($predmeti_res);
      $i = 1;

      /*MOJI PREDMETI - UČENEC*/
      if($predmeti_num > 0){
        echo "
        <div class='container'>
            <div class='kontainer'>
              <div><p class='title'>Moji predmeti</p></div>
              <div></div>
              <div class='plusek'><img src='Pictures/edit.png' id='edit' onclick='EditMode(1)'></div>
            </div>

            <div class='Predmeti'>
                <table class='miza'> 
        ";

        while ($rows = mysqli_fetch_assoc($predmeti_res)) {      //tuki se izpisejo vsi predmeti iz db
          if ($predmeti_num > $i && $i != $predmeti_num) {
            $i++;

            echo " <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a><a href='Scripts/delete.php?type=3&id=$rows[id_predmet]'><img src='Pictures/trash.png'  class='trashIcon trashcan' </a> </td> </tr> ";
          } else {

            echo "  <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a><a href='Scripts/delete.php?type=3&id=$rows[id_predmet]'><img src='Pictures/trash.png'  class='trashIcon trashcan' </a></td></tr> <tr><td rowspan='1'></td></tr> ";
          }
        }

        echo "
            </table>
            </div>
          </div>
        ";
        
      }
      /*MOJI PREDMETI - UČENEC*/

      /*OSTALI PREDMETI - UČENEC*/
      $predmeti_query = "SELECT * 
      FROM `predmeti` 
      WHERE `id_predmet` NOT IN(
        SELECT `id_predmet` 
        FROM `ucilnica`
        WHERE `id_user` = '$id'  
      )
      ";
      $predmeti_res = mysqli_query($db, $predmeti_query);
      $predmeti_num = mysqli_num_rows($predmeti_res);
      $i = 1;

      /*OSTALI PREDMETI - UČENEC*/
      echo "
      <div class='container'>
          <div class='kontainer'>
              <div>
                <button id='btn' type='button' onclick='AllClasses()' class='btn'>Vsi predmeti <img id='arrow_img' class='arrow_img' src='Pictures/triangle_up.png'></button>
                <!--<img id='arrow_img' class='arrow_img' src='Pictures/triangle_up.png'>-->
              </div>
          </div>

          <div class='Predmeti' id='predmeti'>
              <table class='miza'> 
      ";

      //tuki se izpisejo vsi predmeti iz db
      if($predmeti_num > 0){
        while ($rows = mysqli_fetch_assoc($predmeti_res)) {      
          if ($predmeti_num > $i && $i != $predmeti_num) {
            $i++;
  
            echo " <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a></td></tr> ";
          } else {
  
            echo "  <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a></td></tr> <tr><td rowspan='1'></td></tr> ";
          }
        }
      }
      
      echo "
          </table>
          </div>
        </div>
      ";
      /*OSTALI PREDMETI - UČENEC*/
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


      $predmeti_query = "SELECT * FROM `predmeti`;";
      $predmeti_res = mysqli_query($db, $predmeti_query);
      $predmeti_num = mysqli_num_rows($predmeti_res);
      $i = 1;
                
      echo "
      <div class='container'>
          <div class='kontainer'>
              <div><p class='title'>Predmeti</p></div>
              <div class='plusek'><a href='AddPredmet.php'>+</a></div>
              <div class='plusek'><img src='Pictures/edit.png' id='edit' onclick='EditMode(1)'></div>
          </div>

          <div class='Predmeti'>
              <table class='miza'> 
      ";

      while ($rows = mysqli_fetch_assoc($predmeti_res)) {      //tuki se izpisejo vsi predmeti iz db
        if ($predmeti_num > $i && $i != $predmeti_num) {
          $i++;

          echo "
          <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a> <a href='Scripts/delete.php?type=3&id=$rows[id_predmet]'><img src='Pictures/trash.png'  class='trashIcon trashcan'</a> <a href='Scripts/signup.php?id=$rows[id_predmet]'><img src='Pictures/add_pfp.png' class='trashIcon trashcan' </a></td> </tr> ";
        } else {

          echo "  <tr><td> <a class='HrefPredmetMain' href='course.php?id=" . $rows['id_predmet'] . "'>" . $rows['ime'] . "</a> <a href='Scripts/delete.php?type=3&id=$rows[id_predmet]'><img src='Pictures/trash.png' class='trashIcon trashcan' </a> <a href='Scripts/signup.php?id=$rows[id_predmet]'><img src='Pictures/add_pfp.png' class='trashIcon trashcan' </a></td><td rowspan='1'></td></tr>";
        }
      }

      echo "
          </table>
          </div>
        </div>
      ";
    }
    ?>

  </div>



</body>
<!--BODY-->

<!--SCRIPT-->
<script src='Scripts/edit.js'></script>
<script>
  EditMode();
  AllClasses();
</script>
<!--SCRIPT-->

</html>