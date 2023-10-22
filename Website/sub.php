<?php
include('Scripts/config.php');
//START THE SESSION
session_start();

if (!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['user_type'], $_SESSION['pass'])) {
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
<html lang="en">

<head>
    <title>Oddaja</title>
    <link rel="stylesheet" type="text/css" href="Stylesheets/sub.css">
    <script src="Scripts/sub.js"></script>
</head>

<body>
    <form class="container">

    <!--TOP-->
        <div class="top">
            <!--PROFILE-->
            <div class="profile_con left">
                <div>
                    <img src="Pictures/stock_pfp.png" class="pfp_img"> 
                </div>
                <div class="username">Uporabniško ime</div>     
            </div>
            <!--PROFILE-->

            <!--OCENA-->
            <div class="grade_con right">
                <span class="title">Ocena:</span> <input type="number" name="grade" class="grade_input" value="90" max="100" maxlength="3" id='grade_input' onfocus="on_change(1)" oninput="on_change(1)" onblur="on_change(2)" required> / 100
            </div>
            <!--OCENA-->
        </div>
    <!--TOP-->


    <!--BOTTOM-->
        <div class="bottom">
            <!--ODDAJA-->
            <div class="file_con left">
                <div class="title">
                    Oddaja:
                </div>
                <div>
                    <img src="Pictures/pdf_file.png" class="file_icon"><a href="Pictures/stock_pfp.png" class="link" download="MarkoSadnik">MarkSadnik1_Naloga1.png</a>
                </div>
                <div>
                    <input type="submit" value="Oceni" class="submit_btn">
                </div>
            </div>
            <!--ODDAJA-->

            <!--KOMENTAR-->
            <div class="comment_con right">
                <span class="title">Komentar:</span> <textarea name="comment" maxlength="100"></textarea>
            </div>
            <!--KOMENTAR-->
        </div>
    <!--BOTTOM-->
    </form>
</body>

<!--SCRIPT-->
<script>
    on_change(2);
</script>
<!--SCRIPT-->

</html>