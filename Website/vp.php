<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

//if the user isn't logged in / session variables aren't set, redirect to login
if (!isset($_SESSION["id"], $_SESSION["username"], $_SESSION["user_type"])) {
    header("location: login.php");
}
//if the user is logged in, allow access
else {
    //echo"<script>alert('". $_SESSION["id"]. "');</script>";
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    $user_type =  $_SESSION["user_type"];
}

//on save changes
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id == $_GET['id']) {
    $password = mysqli_escape_string($db, $_POST['password']);
    $more = mysqli_escape_string($db, $_POST['opis']);

    $update_query = "UPDATE `user` SET `geslo` = '$password', `opis` = '$more' WHERE `id_user` = '$id';";
    $update_result = mysqli_query($db, $update_query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="Scripts/vp.js"></script>
    <script src="Scripts/login.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaš profil</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/vp.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
</head>

<body>

    <div class="bannerVP">
        <div class="navbar">
        <?php
            //teachers
            if ($user_type == '1') {
                echo "
                <a href='home.php'><img src='Pictures/logo1.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='$$$'>Učenci</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //students
            else if ($user_type == '2') {
                echo "
                <a href='home.php'><img src='Pictures/logo2.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            //admin
            else {
                echo "
                <a href='home.php'><img src='Pictures/logo.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li> <a href='$$$'>Uporabniki</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }    
        ?>
        </div>

        <!--EDIT MODE-->
        <form class="contentVP" method="post" action="">

        <?php
            //check if the user id is defined in the link
            if (isset($_GET['id'])) {

                //search for user with the given id
                $sql_query = "SELECT * FROM `user` WHERE `id_user` = '" . $_GET['id'] . "';";
                $sql_result = mysqli_query($db, $sql_query);
                $returned_rows = mysqli_fetch_assoc($sql_result);
                $count = mysqli_num_rows($sql_result);

                //display info if there is a result
                if($count != 0){
                    echo"
                        <!--TITLE-->
                        <div class='user_title'>
                            <div class='user_name_wrap'>
                                <div class='user_name'>
                                    <p>" . $returned_rows["username"] . "</p>
                                </div>
                                <div class='role_vp'>
                                    <p>";
                    
                    //Check if the user is admin
                    if($returned_rows["user_type"] == 0){
                        echo "Admin";
                    }
                    //Check if the user is a professor
                    else if($returned_rows["user_type"] == 1){
                        echo "Profesor";
                    }
                    //Check if the user is a student
                    else{
                        echo "Učenec";
                    }

                    echo        "</p>
                            </div>
                        </div>  
                        <div class='img_wrap'>
                            <img class='vp_pfp' src='Pictures/stock_pfp.png'>
                        </div>
                    </div>
                    <!--TITLE-->";

                    //edit mode
                    if($_GET['id'] == $id){
                        echo"
                        <!--DETAILS-->
                        <div class='user_info'>
                            <div class='password'>
                                <div class='left'>Geslo:</div>
                                <div class='pass_wrap right'>
                                    <input name='password' type='password' value='" . $returned_rows["geslo"] . "' class='input_field normal_field' onfocus='on_change(1)' onblur='on_change(2)' oninput='passwordFieldWidth()' id='pass_field' maxlength='50' required>
                                    <button type='button' id='show_btn' class='show_button' onclick='click_show_button()'>Show</button>
                                    <script defer>
                                        passwordFieldWidth();
                                    </script>
                                </div>
                            </div>
                            <div class='teachers'>
                                <div>Profesorji:</div>
                                <div>
                                    <ul class='list_prof'>    
                                        <li>Koren</li>
                                        <li>Koren</li>
                                    </ul>
                                </div>
                            </div>
                            <div class='about'>
                                <div>Več o uporabniku:</div>
                                <div class='about_wrap'>
                                    <textarea name='opis' class='input_field' maxlength='255' placeholder='[uporabnik ni dodal dodatnih informacij]' id='textarea_field' oninput='textAreaSize()'>";
                        
                        if($returned_rows["opis"] == ""){
                            echo "[uporabnik ni dodal dodatnih informacij]";
                        }
                        else{
                            echo $returned_rows["opis"];
                        }

                        echo "</textarea>
                                </div>
                            </div>
                            <div class='submit'>
                                <input type='submit' class='submit_btn' value='Shrani spremembe'>
                            </div>
                        </div>
                        <!--DETAILS-->
                        ";
                    }
                    //readonly mode
                    else{
                        echo"
                        <!--DETAILS-->
                        <div class='user_info'>
                            <div class='teachers'>
                                <div>Profesorji:</div>
                                <div>
                                    <ul class='list_prof'>    
                                        <li>Koren</li>
                                        <li>Koren</li>
                                    </ul>
                                </div>
                            </div>
                            <div class='about'>
                                <div>Več o uporabniku:</div>
                                <div class='about_wrap'>
                                    <textarea name='opis' class='input_field' maxlength='255' placeholder='[uporabnik ni dodal dodatnih informacij]' id='textarea_field' oninput='textAreaSize()' readonly>";

                        if($returned_rows["opis"] == ""){
                            echo "[uporabnik ni dodal dodatnih informacij]";
                        }
                        else{
                            echo $returned_rows["opis"];
                        }
                        echo "</textarea>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('textarea_field').style.outline = 'none';
                        </script>
                        <!--DETAILS-->
                        ";
                    }
                }
                
                //if the user doesn't exist, redirect to home page
                else{
                    header("location: vp.php?id=" . $id);
                }
            }
            //if not, redirect to home page
            else{
                header("location: home.php");
            }
            ?>

        </form>
        <!--EDIT MODE-->
    </div>

</body>
</html>