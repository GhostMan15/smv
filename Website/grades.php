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
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
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
        $id_gradiva = $_GET['gradivo'];
        $exists_query = "SELECT `g`.`id_gradiva`, `g`.`naslov` AS `g_naslov`, `p`.`id_predmet` AS `p_id_predmet` 
        FROM `gradiva` `g` JOIN `model` `m`
            ON `g`.`id_modula` = `m`.`id_modela` JOIN `predmeti` `p`
            ON `m`.`id_predmet` = `p`.`id_predmet`
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
    ?>

    
</body>
</html>