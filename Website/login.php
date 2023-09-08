<?php
include("Scripts/config.php");


?>

<!DOCTYPE html>
<html lang="en">

<!--HEAD-->

<head>
    <script src="Scripts/login.js"></script>
    <meta name="author" content="Mark Sadnik">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/login.css">
    <title>Login to Ultis</title>
</head>
<!--HEAD-->

<!--BODY-->

<body>
    <!--MAIN-->
    <form method="post" action="login.php" class="main">

        <!--ICON-->
        <div class="top">
            <div class="img_con">
                <img src="Pictures/logo.png" class="logo">
            </div>
        </div>
        <!--ICON-->

        <!--FORM-->
        <div class="form middle">
            <div class="username">
                <div class="field_title" id="user_title">
                    Username
                </div>
                <div>
                    <input type="text" name="username" class="field" id="user_field" required onblur="delete_spaces()">
                </div>
            </div>
            <div class="password">
                <div class="field_title" id="pass_title">
                    <div class="pass_head">
                        Password
                    </div>
                    <div class="show_con">
                        <button type="button" class="show_button" id="show_btn" onclick="click_show_button()">Show</button>
                    </div>
                </div>
                <div>
                    <input type="password" name="password" id="pass_field" class="field" required onblur="delete_spaces()">
                </div>
            </div>
        </div>
        <!--FORM-->

        <!--BUTON-->
        <div class="bottom">
            <div class="error" id="error_login"></div>
            <div>
                <input type="submit" class="submit_btn" value="Login">
            </div>
        </div>
        <!--BUTTON-->

    </form>
    <!--MAIN-->

</body>
<!--BODY-->

</html>