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
                    $class_query = "SELECT `u`.*, `kratica` 
                    FROM `ucilnica` `u` JOIN `predmeti` `p`
                    ON `u`.`id_predmet` = `p`.`id_predmet` 
                    WHERE `u`.`id_user` = '$id_user';";
                    $class_result = mysqli_query($db, $class_query);
                    $class_count = mysqli_num_rows($class_result);

                    //user is signed up to at least 1 class
                    if($class_count > 0){
                        //first check if the user logged in is a teacher
                        $is_teacher = false;
                        
                        //loop through all possible teachers
                        while($class_row = mysqli_fetch_assoc($class_result) && $is_teacher == false){
                            $id_predmet = $class_row['id_predmet'];
                            $tmp_query = "SELECT * 
                            FROM `ucilnica`
                            WHERE `id_predmet` = '$id_predmet' 
                            AND `id_user` != '$id_user'; 
                            ";
                            $tmp_result = mysqli_query($db, $tmp_query);
                            $tmp_count = mysqli_num_rows($tmp_result);

                            if($tmp_count > 0){
                                while($tmp_row = mysqli_fetch_assoc($tmp_result)){
                                    if($tmp_row['id_user'] == $id){
                                        $is_teacher = true;
                                        break;
                                    }
                                }
                            }
                        }

                        //check that the user trying to display grades is either a teacher, admin, or the student himself
                        if($user_type == 0 || ($is_teacher && $user_type == 1) || $id_user == $id){
                            
                            /*------------------------TITLE------------------------*/
                            echo"
                            <!--TITLE-->
                            <div class='top'>
                                <p class='title'>
                                    Redovalnica
                                </p>";

                            //display name of the user if the grades are not his own
                            if($id_user != $id){
                                echo"
                                <p>
                                    <a class='link' href='vp.php?id=$id_user' target='__blank__'>". $user_row['ime'] ." ". $user_row['priimek'] ."</a>
                                </p>
                                ";
                            }
                            echo"
                            </div>
                            <!--TITLE-->
                            ";
                            /*------------------------TITLE------------------------*/

                            /*------------------------TABLE------------------------*/
                            echo"
                            <!--TABLE-->
                            <div class='mid'>
                            ";

                            $grade_count = 0;
                            $total_count = 0; 

                            //PREDMET
                            while($row = mysqli_fetch_assoc($class_result)){
                                $course_id = $row['id_predmet'];
                                $kratica = $row['kratica'];

                                $course_grade_count = 0;
                                $course_total = 0;

                                
                                echo"
                                <!--PREDMET-->
                                <div class='row'>
                                ";

                                echo"
                                    <div class='sub_name'>
                                        <a href='course.php?id=$course_id' class='link'>$kratica</a>
                                    </div>
                                ";  

                                //OCENE
                                echo"
                                    <div class='grade_row'>
                                ";

                                $oddaja_query = "SELECT `o`.*
                                FROM `oddaja` `o` JOIN `gradiva` `g`
                                    ON `o`.`id_gradiva` = `g`.`id_gradiva` JOIN `model` `m`
                                    ON `g`.`id_modula` = `m`.`id_modula` JOIN `predmeti` `p`
                                    ON `m`.`id_predmet` = `p`.`id_predmet`
                                WHERE `p`.`id_predmet` = '$course_id' 
                                AND `o`.`id_user` = '$id_user'
                                AND `o`.`ocena` IS NOT NULL;";
                                $oddaja_result = mysqli_query($db, $oddaja_query);
                                $oddaja_count = mysqli_num_rows($oddaja_result);

                                //vrnjene ocene
                                if($oddaja_count > 0){
                                    while($oddaja_row = mysqli_fetch_assoc($oddaja_result)){
                                        $id_oddaja = $grade_row['id_oddaja'];
                                        $id_gradiva = $grade_row['id_gradiva'];
                                        $ocena = $grade_row['ocena'];

                                        if($user_type == 0 || $user_type == 1){
                                            echo"
                                            <div class='grade'>
                                                <a href='grades.php?oddaja=$id_oddaja' class='link'>$ocena</a>
                                            </div>
                                            ";
                                        }
                                        else{
                                            echo"
                                            <div class='grade'>
                                                <a href='material.php?gradivo=$id_gradiva' class='link'>$ocena</a>
                                            </div>
                                            ";
                                        }

                                        $total_count += $ocena;
                                        $grade_count++;
                                        
                                        $course_grade_count++;
                                        $course_total += $ocena;
                                    }
                                }

                                //nima ocen v predmetu
                                else{
                                    echo"
                                    <div class='grade'>
                                        \
                                    </div>
                                    ";
                                }

                                echo"
                                    </div>
                                ";
                                //OCENE

                                //AVG
                                $course_avg = floor($course_total / $course_grade_count);
                                if($course_avg >= 50){
                                    echo"
                                    <div class='avg_row green'>
                                        $course_avg%
                                    </div>
                                    ";
                                }
                                else{
                                    echo"
                                    <div class='avg_row red'>
                                        $course_avg%
                                    </div>
                                    "; 
                                }
                                        

                                echo"
                                </div>
                                <!--PREDMET-->
                                ";
                            }
                            //PREDMET

                            //AVG
                            $avg_total = floor($total_count / $grade_count);
                            echo"
                            <!--AVG-->
                            <div class='bottom_row'> 
                                    <div class='avg_title bold'>
                                        Povprečje
                                    </div>
                            ";

                            if($avg_total >= 50){
                                echo"
                                <div class='avg_row green bold'>
                                    $avg_total%
                                </div>
                                ";
                            }
                            else{
                                echo"
                                <div class='avg_row red bold'>
                                    $avg_total%
                                </div>
                                ";
                            }
                                    
                            echo"
                            </div>
                            <!--AVG-->
                            ";
                            //AVG

                            echo"
                            </div>
                            <!--TABLE-->
                            ";
                            /*------------------------TABLE------------------------*/
                        }

                        //the user is another student trying to acces grades - redirect to home.php
                        else{
                            header("location: home.php");
                        }
                    }

                    //user is not signed into any classes, display empty table
                    else if($id_user == $id || $user_type == 0 || $user_type == 1){
                            echo"
                            <!--TITLE-->
                            <div class='top'>
                                <p class='title'>
                                    Redovalnica
                                </p>
                            ";
                            //display name of the user if the grades are not his own
                            if($id_user != $id){
                                echo"
                                <p>
                                    <a class='link' href='vp.php?id=$id_user' target='__blank__'>". $user_row['ime'] ." ". $user_row['priimek'] ."</a>
                                </p>
                                ";
                            }
                            
                            echo"
                            </div>
                            <!--TITLE-->
                            ";

                            echo"
                            <!--TABLE-->
                            <div class='mid'>
                                <!--PREDMET-->
                                <div class='row'>
                                        <div class='sub_name'>
                                            \
                                        </div>
                
                                        <div class='grade_row'>
                                            <div class='grade'>
                                                \
                                            </div>
                                        </div>
                                        
                                        <div class='avg_row'>
                                            \
                                        </div>
                                </div>
                                <!--PREDMET-->
                            </div>
                            <!--TABLE-->
                            ";
                    }

                    else{
                        header("location: home.php");
                    }
            }

            //user doesn't exist / is not a student
            else{
                header("location: home.php");
            }
        }

        //GET variable not set
        else{
            header("location: home.php");
        }
        ?>

        </div>
        <!--MAIN-->

            
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
                        
                        <div class='avg_row green bold'>
                            $avg_total%
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