<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

if (!isset($_SESSION["id"], $_SESSION["username"], $_SESSION["user_type"], $_SESSION['pass'])) {
    header("location: login.php");
}

//if the user is logged in, allow access
else {
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];

    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $pass = $_SESSION['pass'];
    $user_type = $type_assoc['user_type'];
    $_SESSION["user_type"] = $user_type;
}
?>

<!DOCTYPE html>
<html lang="en">
<!--HEAD-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradivo</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/material.css">
    <script src="Scripts/material.js"></script>
</head>
<!--HEAD-->

<body>

    <!--MAIN-->
    <div class="main">

        <!--NAV-->
        <div class="navbar_div">
            <div class="navbar">
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

        <!--CONTAINER-->
        <form class="container">
            <div class="content">
                
                <!--TOP-->        
                <div class="top">
                    <div class="title_con" id='title_div'>
                        <input type="text" name="title" class="title" value='Naloga1' required maxlength="50" id='title_field' onfocus="on_change(1)" onblur="on_change(2)">
                    </div>
                    <div class="subject_con title">
                        MAT
                    </div>
                </div>
                <!--TOP-->

                <!--MID-->
                <div class="mid">
                    <div class="text_con">
                        <textarea name="description" id='textarea_field' placeholder="vpišite besedilo..." oninput="textAreaSize()" onfocus="on_change(3)" onblur="on_change(4)"></textarea>
                    </div>
                </div>
                <!--MID-->

                <!--BOTTOM-->
                <div class="bottom">

                    <!--PRILOGE-->
                    <div class="title2">Priloge</div>
                    <div class="prof_files">
                        <div class="prof_row">
                            <img src="Pictures/zip_file.png" class="file_icon"> <a href="$$$">ZIP_datoteka.zip</a>
                        </div>
                        <div class="prof_row">
                            <img src="Pictures/pdf_file.png" class="file_icon"> <a href="$$$">PDF_datoteka.pdf</a>
                        </div>
                        <div class="prof_row">
                            <img src="Pictures/file_default.png" class="file_icon"> <a href="Scripts/vp.js" download="PriimekIme-Naloga1">NEZNANA_datoteka.random_datoteka</a>
                        </div>
                    </div>
                    <!--PRILOGE-->

                    <!--STANJE ODDAJE-->
                    <div class="title2">Stanje naloge</div>
                    <table class="table">
                        <tr class="submission">
                            <td class="t_left">
                                Stanje
                            </td> 
                            <td>
                                Oddano/Neoddano
                            </td>
                        </tr>
                        <tr class="due">
                            <td class="t_left">
                                Rok oddaje
                            </td>
                            <td>
                                14.10.2023
                            </td>
                        </tr>
                        <tr class="date_added">
                            <td class="t_left">
                                Datum oddaje
                            </td>
                            <td>
                                14.10.2023
                            </td>
                        </tr>
                        <tr class="mark">
                            <td class="t_left bottom_row">
                                Ocena
                            </td>
                            <td class="bottom_row">
                                76/100
                            </td>
                        </tr>
                    </table>
                    <!--STANJE ODDAJE-->

                    <!--ODDAJA-->
                    <div class="title2">Oddaja <span class="accepted"></span></div>
                    <div class="submit_con">
                        <div class="file_upload_con">
                            <input type="file" class="file_upload">
                        </div>
                        <div class="submit_btn_con">
                            <input type="submit" class="submit_btn" value="Oddaj">
                        </div>
                    </div>
                    <!--ODDAJA-->

                </div>
                <!--BOTTOM-->
            </div>
        </form>
        <!--CONTAINER-->

    </div>
    <!--MAIN-->

    <!--SCRIPT-->
    <script>
        textAreaSize();
        on_change(2);
    </script>
    <!--SCRIPT-->

</body>

</html>