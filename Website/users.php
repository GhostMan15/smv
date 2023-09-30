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
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    $user_type = $_SESSION["user_type"];
}
//check if user is admin, if not redirect to homepage
if ($user_type != "0") {
    header("location: home.php");
}
?>

<!DOCTYPE html>
<html>

<!--HEAD-->

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Mark Sadnik">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Stylesheets/users.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
    <title>Uporabniki</title>
</head>
<!--HEAD-->

<!--BODY-->

<body>
    <!--NAVBAR-->
    <div class="navbar_wrap">
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
                <a href='home.php'><img src='Pictures/logo0.png' class='logo'></a>
                <ul>
                    <li> <a href='home.php'>Domov</a></li>
                    <li> <a href='class.php'>Predmeti</a></li>
                    <li id='checked'> <a href='users.php'>Uporabniki</a></li>
                    <li> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }
            ?>
        </div>
    </div>

    <!--CONTENT-->
    <div class="main">
        <div class="container">

            <!--TOP-->
            <div class="top">
                <div class="top_inner">
                    <button type="button" class="add_btn" onclick="redirect()"><img src="Pictures/add_pfp.png" class="add_pic"></button>
                </div>
            </div>
            <!--TOP-->

            <!--ROWS-->
            <div class="content">
                <!--STUDENTS-->
                <div class="students_con">
                    <div class="students_title title">
                        <button class="title_btn">Učenci (5) <img src="Pictures/triangle_up.png" class="btn_pic" id="pic1" onclick="toggle(1)"></button>
                    </div>
                    <div class="students_list" id="table1">
                        <table class="student_table table">
                            <tr>
                                <td class="username_Data">
                                    Liam Smith
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>

                            <tr>
                                <td class="username_Data">
                                    Liam Smithsadasddddddddddddd
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--STUDENTS-->

                <!--TEACHERS-->
                <div class="teachers_con">
                    <div class="teachers_title title">
                        <button class="title_btn">Profesorji (20) <img src="Pictures/triangle_up.png" class="btn_pic" id="pic2" onclick="toggle(2)"></button>
                    </div>
                    <div class="teachers_list" id="table2">
                        <table class="teacher_table table">
                            <tr>
                                <td class="username_Data">
                                    Liam Smith
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>

                            <tr>
                                <td class="username_Data">
                                    Liam Smithsadasddddddddddddd
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--TEACHERS-->

                <!--ADMIN-->
                <div class="admin_con">
                    <div class="admin_title title">
                        <button class="title_btn">Administratorji (3) <img src="Pictures/triangle_up.png" class="btn_pic" id="pic3" onclick="toggle(3)"></button>
                    </div>
                    <div class="admin_list" id="table3">
                        <table class="admin_table table">
                            <tr>
                                <td class="username_Data">
                                    Liam Smith
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>

                            <tr>
                                <td class="username_Data">
                                    Liam Smithsadasddddddddddddd
                                </td>
                                <td>
                                    Izbriši
                                </td>
                                <td>
                                    Profil
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--ADMIN-->
            </div>
            <!--ROWS-->
        </div>
    </div>
    <!--CONTENT-->

    <!--SCRIPT-->
    <script src="Scripts/register.js"></script>
    <script>
        document.getElementById('table1').style.display = "none";
        document.getElementById('table2').style.display = "none";
        document.getElementById('table3').style.display = "none";
    </script>
    <!--SCRIPT-->
</body>
<!--BODY-->

</html>