<?php
include('config.php');
//START THE SESSION
session_start();

if (!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['user_type'], $_SESSION['pass'])) {
    header('location: ../login.php');
}

$ime = "";
$priimek = "";

//if the user is logged in, allow access
else {
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];

    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $ime = $type_assoc['ime'];
    $priimek = $type_assoc['priimek'];
    $pass = $_SESSION['pass'];
    $user_type = $type_assoc['user_type'];
    $_SESSION['user_type'] = $user_type;
}
?>

<!DOCTYPE html>
<html>
<!--HEAD-->
<head>
    <title>Prijava na predmet</title>
    <link rel='stylesheet' type='text/css' href='../Stylesheets/signup.css'>
    <link rel='stylesheet' type='text/css' href='../Stylesheets/navbar.css'>
    <script>
        function go_back(){
            history.go(-1);
        }
    </script>
</head>
<!--HEAD-->

<!--BODY-->
<body>
    <!--NAV-->
    <div class='navbar_div'>
            <div class='navbar'>
            <?php
                //teachers
                if ($user_type == 1) {
                    header("location: ../class.php");
                }
                //students
                else if ($user_type == 2) {
                    echo "
                    <a href='home.php'><img src='../Pictures/logo2.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li> <a href='redovalnica.php'>Ocene</a></li>
                        <li> <a href='vp.php'>Vaš Profil</a></li>
                        <li> <a href='Scripts/logout.php'>Odjava</a></li>
                    </ul>
                    ";
                }
                //admin
                else if ($user_type == 0){
                    echo "
                    <a href='home.php'><img src='../Pictures/logo0.png' class='logo'></a>
                    <ul>
                        <li> <a href='home.php'>Domov</a></li>
                        <li id='checked'> <a href='class.php'>Predmeti</a></li>
                        <li><a href='redovalnica.php'>Redovalnica</a></li>
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
        <form class='main' method='post'>
        
        <?php
        if(isset($_GET['id'])){
            $id_predmet = $_GET['id'];
            //check that class exists
            $class_query = "SELECT * FROM `predmeti` WHERE `id_predmet` = '$id_predmet';";
            $class_result = mysqli_query($db, $class_query);
            $class_count = mysqli_num_rows($class_result);

            //class exists
            if($class_count > 0){
                //check that the user is an admin or student trying to sign up
                if($user_type == 0 || $user_type == 2){
                    //check if the user is a student and already signed up
                    if($user_type == 2){
                        $sign_up_query = "SELECT * FROM `ucilnica` 
                        WHERE `id_predmet` = '$id_predmet' 
                        AND `id_user` = '$id';";
                        $sign_up_result = mysqli_query($db, $sign_up_query);
                        $sign_up_count = mysqli_num_rows($sign_up_result);
                        
                        //if the user is already signed up, redirect to that class
                        if($sign_up_count > 0){
                            header("location: ../course.php?id=$id_predmet");
                        }
                    }

                    //display HTML
                    $class_row = mysqli_fetch_assoc($class_result);
                    echo"
                    <div class='title_con'>
                        <p class='title'>
                            Prijava na predmet:
                        </p>
                        <p class='title bold'>
                            " . $class_row['kratica'] . . "-" . $class_row['ime'] . "
                        </p>
                    </div>
                    ";

                    //display the user being signed up, admin - dropdown, student - plain text
                    
                    //ADMIN view
                    if($user_type == 0){
                        //get all the students and professors, not signed up to the class
                        $users_query = "SELECT * FROM `user`
                        WHERE `user_type` IN('1', '2')
                        AND `id_user` NOT IN(
                            SELECT `id_user` 
                            FROM `ucilnica`
                            WHERE `id_predmet` = '$id_predmet'
                        );
                        ";
                        $users_result = mysqli_result($db, $users_query);
                        $users_count = mysqli_num_rows($users_result);

                        //if there are users to display, render dropdown
                        if($users_count > 0){
                            echo"
                                <div class='dropdown_con'>
                                    <div class='dropdown_title'>
                                        Uporabnik:
                                    </div>
                                    <div class='dropdown_div'>
                                        <select name='id_user' class='dropdown'>
                            ";

                            while($users_row = mysqli_fetch_assoc($users_result)){
                                //student
                                if($users_row['user_type'] == 2){
                                    echo"
                                            <option value='". $users_row['id_user'] ."'>(U) ". $users_row['ime'] . $users_row['priimek'] . "</option>
                                    ";
                                }

                                //teacher
                                else if($users_row['user_type'] == 1){
                                    echo"
                                            <option value='". $users_row['id_user'] ."'>(P) ". $users_row['ime'] . $users_row['priimek'] . "</option>
                                    ";
                                }
                            }

                            echo"
                                        </select>
                                    </div>
                                </div>
                            ";
                        }
                        //if there are no users to sign up, redirect to course.php
                        else{
                            header("location: ../course.php?id=$id_predmet");
                        }
                    }

                    //STUDENT VIEW
                    else{  
                        echo"
                        <div class='user_con'> 
                            Učenec: <a href='../vp.php'>$ime $priimek</a>
                        </div>
                        ";
                    }

                    //DISPLAY BUTTONS
                    echo"
                    <div class='btn_con'>
                        <div class='back_btn_con'>
                            <button type='button' class='back_btn btn' onclick='go_back()'><img src='../Pictures/back.png' class='img'></button>
                        </div>
                        <div class='submit_btn_con'>
                            <input type='submit' class='submit_btn btn' value='Prijava'>
                        </div>
                    </div>";
                }
            
            }
            //class doesn't exist
            else{
                header("location: ../class.php");
            }
        }
        //variable not set
        else{
            header("location: ../class.php");
        }
        ?>

        <!--
            <div class='title_con'>
                <p class='title'>
                Prijava na predmet:
                </p>
                <p class='title bold'>
                NUP - upravas
                </p>
            </div>

            <div class='user_con'> 
                Učenec: <a href='../vp.php'>Mark Sadnik</a>
            </div>-->

            <!--DROPWDONW - ADMIN
            <div class='dropdown_con'>
                <div class='dropdown_title'>
                    Uporabnik:
                </div>
                <div class='dropdown_div'>
                    <select name='id_user' class='dropdown'>
                        <option value='135'>(U) Mark Sadnik</option>
                    </select>
                </div>
            </div>
            DROPDOWN - ADMIN-->

            <!--
            <div class='btn_con'>
                <div class='back_btn_con'>
                    <button type='button' class='back_btn btn' onclick='go_back()'><img src='../Pictures/back.png' class='img'></button>
                </div>
                <div class='submit_btn_con'>
                    <input type='submit' class='submit_btn btn' value='Prijava'>
                </div>
            </div>-->
        </form>
    </div>
    <!--CONTAINER-->
</body>
<!--BODY-->
</html>