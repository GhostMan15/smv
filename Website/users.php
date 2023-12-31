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
    
    //double check user type - there were some issues with this session variable
    $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
    $type_result = mysqli_query($db, $type_query);
    $type_assoc = mysqli_fetch_assoc($type_result);
    $user_type =  $type_assoc['user_type'];
    $_SESSION["user_type"] = $user_type;
}
//check if user is admin, if not redirect to homepage
if ($user_type != 0 && $user_type != 1) {
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
                    <li id='checked'> <a href='users.php'>Učenci</a></li>
                    <li> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
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
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
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
                    <li> <a href='Scripts/logout.php'>Odjava</a></li>
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
            <?php
            //if user is admin, show 'add' button
            if($user_type == 0){
                echo"
                <div class='top'>
                    <div class='top_inner'>
                        <button type='button' class='add_btn' onclick='redirect()'><img src='Pictures/add_pfp.png' class='add_pic'></button>
                    </div>
                </div";
            }
            
            ?>
            <!--TOP-->

            <!--ROWS-->
            <div class="content">
                <!--STUDENTS-->
                <?php
                //get all students from db
                $student_query = "SELECT * FROM `user` WHERE `user_type` = '2';";
                $student_result = mysqli_query($db, $student_query);
                $student_count = mysqli_num_rows($student_result);

                //admin
                if($user_type == 0){
                    echo"
                    <div class='students_con'>
                            <div class='students_title title'>
                                <button class='title_btn'>Učenci ($student_count) <img src='Pictures/triangle_up.png' class='btn_pic' id='pic1' onclick='toggle(1)'></button>
                            </div>
                            <div class='students_list' id='table1'>
                                <table class='student_table table'>
                    ";

                    while($row = mysqli_fetch_assoc($student_result)){
                        echo "
                        <tr>
                            <td class='username_data'>
                                <a class='user_link' href='vp.php?id=". $row['id_user'] ."' target='__blank__'>". $row['username'] ."</a>                                        
                            </td>
                            <td class='delete_data'>
                                <button type='button' class='delete_btn table_btn' onclick='delete_user(". $row['id_user'] .")'><img class='delete_img img' src='Pictures/delete.png'></button>
                            </td>
                        ";
                        
                        if($row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $row['id_user'] . "." . $row["img_ext"])){
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $row['id_user'] .")'><img class='profile_img img' src='Pictures/Profile_Pictures/pfp_". $row['id_user'] . "." . $row["img_ext"] ."'></button>
                            </td>
                            ";
                        }
                        else{
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $row['id_user'] .")'><img class='profile_img img' src='Pictures/stock_pfp.png'></button>
                            </td>
                            ";
                        }

                        echo"
                            <td class='grade_data'>
                                <button type='button' class='grade_btn table_btn' onclick='grade(". $row['id_user'] .")'><img class='grade_img img' src='Pictures/doc_icon.png'></button>
                            </td>
                        ";
                        
                        echo"
                        </tr>
                        ";
                    }

                    echo"
                    </table>
                    </div>
                    </div>
                    ";
                }

                //professor
                else if($user_type == 1){
                    //get all students that the teacher teaches
                    $student_teacher_query = "SELECT DISTINCT `us`.*
                    FROM `ucilnica` `u1` JOIN `ucilnica` `u2` 
                        ON `u1`.`id_predmet` = `u2`.`id_predmet` JOIN `user` `us` 
                        ON `u2`.`id_user` = `us`.`id_user`
                    WHERE `u1`.`id_user` = '$id' 
                    AND `u1`.`id_user` != `u2`.`id_user`
                    AND `us`.`user_type` = 2
                    ";
                    $student_teacher_result = mysqli_query($db, $student_teacher_query);
                    $student_teacher_count = mysqli_num_rows($student_teacher_result);


                    echo"
                    <div class='students_con'>
                            <div class='students_title title'>
                                <button class='title_btn'>Učenci ($student_teacher_count) <img src='Pictures/triangle_up.png' class='btn_pic' id='pic1' onclick='toggle(1)'></button>
                            </div>
                            <div class='students_list' id='table1'>
                                <table class='student_table table'>
                    ";

                    while($row = mysqli_fetch_assoc($student_teacher_result)){
                        echo "
                        <tr>
                            <td class='username_data'>
                                <a class='user_link' href='vp.php?id=". $row['id_user'] ."' target='__blank__'>". $row['username'] ."</a>
                            </td>
                        ";
                        
                        if($row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $row['id_user'] . "." . $row["img_ext"])){
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $row['id_user'] .")'><img class='profile_img img' src='Pictures/Profile_Pictures/pfp_". $row['id_user'] . "." . $row["img_ext"] ."'></button>
                            </td>
                            ";
                        }
                        else{
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $row['id_user'] .")'><img class='profile_img img' src='Pictures/stock_pfp.png'></button>
                            </td>
                            ";
                        }
                        
                        echo"
                            <td class='grade_data'>
                                <button type='button' class='grade_btn table_btn' onclick='grade(". $row['id_user'] .")'><img class='grade_img img' src='Pictures/doc_icon.png'></button>
                            </td>
                        ";
                        
                        echo"
                        </tr>
                        ";
                    }

                    echo"
                    </table>
                    </div>
                    </div>";
                }
                
                ?>
                <!--STUDENTS-->

                <!--TEACHERS-->
                <?php
                //get all teachers from db
                $teachers_query = "SELECT * FROM `user` WHERE `user_type` = '1';";
                $teachers_result = mysqli_query($db, $teachers_query);
                $teachers_count = mysqli_num_rows($teachers_result);
                
                //admin
                if($user_type == 0){
                    echo"
                    <div class='teachers_con'>
                            <div class='teachers_title title'>
                                <button class='title_btn'>Učitelji ($teachers_count) <img src='Pictures/triangle_up.png' class='btn_pic' id='pic2' onclick='toggle(2)'></button>
                            </div>
                            <div class='teachers_list' id='table2'>
                                <table class='teachers_table table'>
                    ";

                    while($teachers_row = mysqli_fetch_assoc($teachers_result)){
                        echo "
                                    <tr>
                                        <td class='username_data'>
                                            <a class='user_link' href='vp.php?id=". $teachers_row['id_user'] ."' target='__blank__'>". $teachers_row['username'] ."</a>
                                        </td>
                                        <td class='delete_data'>
                                            <button type='button' class='delete_btn table_btn' onclick='delete_user(". $teachers_row['id_user'] .")'><img class='delete_img img' src='Pictures/delete.png'></button>
                                        </td>
                        ";
                        
                        if($teachers_row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $teachers_row['id_user'] . "." . $teachers_row["img_ext"])){
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $teachers_row['id_user'] .")'><img class='profile_img img' src='Pictures/Profile_Pictures/pfp_". $teachers_row['id_user'] . "." . $teachers_row["img_ext"] ."'></button>
                            </td>
                            ";
                        }
                        else{
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $teachers_row['id_user'] .")'><img class='profile_img img' src='Pictures/stock_pfp.png'></button>
                            </td>
                            ";
                        }
                        
                        echo"</tr>";
                    }

                    echo"
                    </table>
                    </div>
                    </div>";
                }

                //teacher
                else if($user_type == 1){
                    echo"
                    <div class='teachers_con'>
                            <div class='teachers_title title'>
                                <button class='title_btn'>Sodelavci ($teachers_count) <img src='Pictures/triangle_up.png' class='btn_pic' id='pic2' onclick='toggle(2)'></button>
                            </div>
                            <div class='teachers_list' id='table2'>
                                <table class='teachers_table table'>
                    ";

                    while($teachers_row = mysqli_fetch_assoc($teachers_result)){
                        if($teachers_row['id_user'] == $id){
                            echo "
                                    <tr>
                                        <td class='username_data'>
                                            <a class='user_link' href='vp.php?id=". $teachers_row['id_user'] ."' target='__blank__'>". $teachers_row['username'] . " (Jaz)</a>
                                        </td>
                            ";
                        }
                        
                        else{
                            echo "
                                    <tr>
                                        <td class='username_data'>
                                            <a class='user_link' href='vp.php?id=". $teachers_row['id_user'] ."' target='__blank__'>". $teachers_row['username'] . "</a>
                                        </td>
                            ";
                        }
                        
                        
                        if($teachers_row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $teachers_row['id_user'] . "." . $teachers_row["img_ext"])){
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $teachers_row['id_user'] .")'><img class='profile_img img' src='Pictures/Profile_Pictures/pfp_". $teachers_row['id_user'] . "." . $teachers_row["img_ext"] ."'></button>
                            </td>
                            ";
                        }
                        else{
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $teachers_row['id_user'] .")'><img class='profile_img img' src='Pictures/stock_pfp.png'></button>
                            </td>
                            ";
                        }
                        
                        echo"</tr>";
                    }

                    echo"
                    </table>
                    </div>
                    </div>";
                }
                ?>
                <!--TEACHERS-->

                <!--ADMIN-->
                <?php
                //get all admins from db
                $admin_query = "SELECT * FROM `user` WHERE `user_type` = '0';";
                $admin_result = mysqli_query($db, $admin_query);
                $admin_count = mysqli_num_rows($admin_result);

                if($user_type == 0){
                    echo"
                    <div class='admin_con'>
                            <div class='admin_title title'>
                                <button class='title_btn'>Administratorji (". $admin_count .") <img src='Pictures/triangle_up.png' class='btn_pic' id='pic3' onclick='toggle(3)'></button>
                            </div>
                            <div class='admin_list' id='table3'>
                                <table class='admin_table table'>
                    ";

                    while($admin_row = mysqli_fetch_assoc($admin_result)){
                        
                        if($admin_row['id_user'] == $id){
                            echo "
                                    <tr>
                                        <td class='username_data'>
                                        <a class='user_link' href='vp.php?id=". $admin_row['id_user'] ."' target='__blank__'>". $admin_row['username'] . " (Jaz)</a>
                                        </td>
                        ";
                        }

                        else{
                            echo "
                                    <tr>
                                        <td class='username_data'>
                                        <a class='user_link' href='vp.php?id=". $admin_row['id_user'] ."' target='__blank__'>". $admin_row['username'] ." </a>
                                        </td>            
                        ";
                        }

                        if($admin_row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $admin_row['id_user'] . "." . $admin_row["img_ext"])){
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $admin_row['id_user'] .")'><img class='profile_img img' src='Pictures/Profile_Pictures/pfp_". $admin_row['id_user'] . "." . $admin_row["img_ext"] ."'></button>
                            </td>
                            ";
                        }

                        else{
                            echo"
                            <td class='profile_data'>
                                <button type='button' class='profile_btn table_btn' onclick='profile(". $admin_row['id_user'] .")'><img class='profile_img img' src='Pictures/stock_pfp.png'></button>
                            </td>
                            ";
                        }

                        echo"
                        </tr>
                        ";
                        
                    }

                    echo"
                    </table>
                    </div>
                    </div>";
                }
                ?>
                <!--ADMIN-->
            </div>
            <!--ROWS-->
        </div>
    </div>
    <!--CONTENT-->
        
    <!--SCRIPT-->
    <script src="Scripts/register.js"></script>
    <!--SCRIPT-->
</body>
<!--BODY-->

</html>