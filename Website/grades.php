<?php
include('Scripts/config.php');
//START THE SESSION
session_start();

if (!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['user_type'], $_SESSION['pass'], $_GET['gradivo'])) {
    header('location: login.php');
}

//if the user is logged in, allow access
else {
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];

    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $pass = $_SESSION['pass'];
    $user_type = $type_assoc['user_type'];
    $_SESSION['user_type'] = $user_type;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ocene</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/grades.css">
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
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
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
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
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

    <?php
        //check if class material exists
        if(isset($_GET['gradivo'])){
            $id_gradiva = $_GET['gradivo'];
            $exists_query = "SELECT `g`.`id_gradiva`, `g`.`naslov` AS `g_naslov`, `p`.`id_predmet` AS `p_id_predmet` 
            FROM `gradiva` `g` JOIN `model` `m`
                ON `g`.`id_modula` = `m`.`id_modela` JOIN `predmeti` `p`
                ON `p`.`id_predmet` = `m`.`id_predmet`
            WHERE `g`.`id_gradiva` = '$id_gradiva';";
            $exists_result = mysqli_query($db, $exists_query);
            $exists_count = mysqli_num_rows($exists_result);

            if($exists_count != 0){
                //check if user is a teacher or admin assigned to the class
                $user_query = "SELECT `id_user`
                FROM `ucilnica` `u` JOIN `predmeti` `p`
                    ON `p`.`id_predmet` = `u`.`id_predmet`
                WHERE `u`.`id_user` = '$id';";
                $user_result = mysqli_query($db, $user_query);
                $user_count = mysqli_num_rows($user_result);

                if($user_type == 0 || ($user_count != 0 && $user_type == 1)){
                    //display all submissions, if there are any
                    $sub_query = "SELECT * FROM `oddaja` 
                    WHERE `id_gradiva` = '$id_gradiva' AND `priloga` = '0';"; 
                    $sub_result = mysqli_query($db, $sub_query);
                    $sub_count = mysqli_num_rows($sub_result);

                    //display submissions
                    if($sub_count != 0){
                        $material_row = mysqli_fetch_assoc($exists_result);
                        echo"
                        <!--CONTAINER-->
                            <div class='container'>
                                <div class='title'>
                                    <p>
                                        Oddaje za nalogo ($sub_count)
                                        <br>
                                        \"" . $material_row['g_naslov'] . "\"
                                    </p>
                                </div>

                                <div class='content'>
                        ";
                        
                        while($row = mysqli_fetch_assoc($sub_result)){
                            echo"    
                                    <div class='oddaja'>
                                        <iframe src='sub.php?oddaja=". $row['id_oddaja'] ."'></iframe>
                                    </div> 
                            ";
                        }

                        echo"
                                </div>
                            </div>
                        <!--CONTAINER-->
                        ";

                    }
                }
                else{
                    header("location: course.php?id=");
                }
            }

            else{
                header("location: class.php");
            }
        }

        //check for specific submission - extension of redovalnica.php
        else if(isset($_GET['oddaja'])){
            $id_oddaja = $_GET['oddaja'];
            //check if submission exists
            $sub_exists_query = "SELECT * FROM `oddaja` WHERE `id_oddaja` = '$id_oddaja';";
            $sub_exists_result = mysqli_query($db, $sub_exists_query);
            $sub_exists_count = mysqli_num_rows($sub_exists_result);

            if($sub_exists_count > 0){
                $sub_row = mysqli_fetch_assoc($sub_exists_result);
                
                //check that user is an admin or a teacher assigned to the class
                $teacher_query = "SELECT `p`.`id_predmet`, `g`.*
                FROM `oddaja` `o` JOIN `gradiva` `g`
                ON `o`.`id_gradiva` = `g`.`id_gradiva` JOIN `m` `model`
                ON `g`.`id_modula` = `m`.`id_modula` JOIN `predmeti` `p`
                ON `m`.`id_predmet` = `p`.`id_predmet`
                WHERE `o`.`id_oddaja` = '$id_oddaja';
                ";
                $teacher_result = mysqli_query($db, $teacher_query);
                $teacher_count = mysqli_num_rows($teacher_result);
                
                if($teacher_count > 0){
                    $teacher_row = mysqli_fetch_assoc($teacher_result);
                    $id_predmet = $teacher_row['id_predmet'];
                    
                    $ucilnica_query = "SELECT `u`.* 
                    FROM `ucilinca` `u` JOIN `predmeti` `p`
                    ON `p`.`id_predmet` = `u`.`id_predmet`
                    WHERE `p`.`id_predmet` = '$id_predmet'
                    AND `u`.`id_user` = '$id';
                    ";
                    $ucilnica_result = mysqli_query($db, $ucilnica_query);
                    $ucilnica_count = mysqli_num_rows($ucilnica_result);

                    if($user_type == 0 || ($ucilnica_count > 0 && $user_type == 1)){
                        echo"
                        <!--CONTAINER-->
                            <div class='container'>
                                <div class='title'>
                                    <p>
                                        Oddaja za nalogo
                                        <br>
                                        \"" . $teacher_row['naslov'] . "\"
                                    </p>
                                </div>

                                <div class='content'>
                        ";

                        echo"    
                                    <div class='oddaja'>
                                        <iframe src='sub.php?oddaja=". $id_oddaja ."'></iframe>
                                    </div> 
                        ";

                        echo"
                                </div>
                            </div>
                        <!--CONTAINER-->
                        ";
                    }
                }
            }
        }

        else{
            header("location: class.php");
        }
    ?>

    
</body>
</html>