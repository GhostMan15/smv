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
    <title>Ocene</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/MojeOcene.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
</head>


<body>
    <!--NAV-->
    <div class='navbar_div'>
            <div class='navbar'>
            <?php
                //teachers
                if ($user_type == 1) {
                    echo "
                    <a href='home.php'><img src='Pictures/logo1.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li> <a href='class.php'>Predmeti</a></li>
                        <li id='checked'><a href='redovalnica.php'>Ocene</a></li>
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
                        <li> <a href='class.php'>Predmeti</a></li>
                        <li id='checked'><a href='redovalnica.php'>Ocene</a></li>
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
                        <li> <a href='class.php'>Predmeti</a></li>
                        <li id='checked'><a href='redovalnica.php'>Redovalnica</a></li>
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
    <div class='container'>

        <!--MAIN-->
        <div class='main'>
        
        <?php
        if(isset($_GET['id'])){
            $id_user = $_GET['id'];
            //check to see if user exists and is a student
            $user_query = "SELECT * FROM `user` WHERE `id_user` = '$id_user';";
            $user_result = mysqli_query($db, $user_query);
            $user_count = mysqli_num_rows($user_result);
            $user_row = mysqli_fetch_assoc($user_result);

            if($user_count > 0 && $user_row['user_type'] == 2){
                //get all classes that the user is assigned to 
                /*------------------------------------TO DO---------------------------*/
            }
        }
        ?>

            
            <!--TITLE-->
            <div class='top'>
                <p class='title'>
                    Redovalnica
                </p>

                <p>
                    <a class='link' href='vp.php?id=x' target='__blank__'>Mark Sadnik</a>
                </p>
            </div>
            <!--TITLE-->

            <!--TABLE-->
            <div class='mid'>

                <!--PREDMET-->
                <div class='row'>
                        <div class='sub_name'>
                            <a href='course.php?id=x' class='link'>MAT</a>
                        </div>

                        <div class='grade_row'>
                            <div class='grade'>
                                <a href='grades.php?oddaja=x' class='link'>100</a>
                            </div>

                            <div class='grade'>
                                <a href='material.php?gradivo=x' class='link'>20</a>
                            </div>
                        </div>

                        <div class='avg_row green'>
                            90%
                        </div>
                </div>
                <!--PREDMET-->

                <!--AVG-->
                <div class='bottom_row'> 
                        <div class='avg_title bold'>
                            Povprečje
                        </div>
                        <div class='avg_row green bold'>
                            75%
                        </div>
                </div>
                <!--AVG-->
            </div>
            <!--TABLE-->

            <!--BOTTOM-->
        </div>
        <!--MAIN-->
    </div>
    <!--CONTAINER-->
</body>
</html>