<?php
include("Scripts/config.php");
//START THE SESSION
session_start();

$_SESSION["login_error"] = "";
$error = "";
$allgood = true;

//EXECUTE ON SUBMITTING OF FORM 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_escape_string($db, $_POST["username"]);
    $password = mysqli_escape_string($db, $_POST["password"]);

    //Check if the credentials are empty
    if($username == "" || $password == ""){
        $error = "Your username / password cannot be empty.";
        $allgood = false;
    }

    //if all is good, execute query to check credentials
    if($allgood){
        //query for a user with the given credentials
        $sql1 = "SELECT * FROM `user` WHERE `username` = '$username' AND `geslo` = '$password'";
        $result1 = mysqli_query($db, $sql1);
        $row = mysqli_fetch_assoc($result1);
        $count = mysqli_num_rows($result1);

        //If there is a result, allow login and store user data in session
        if($count == 1){
            $_SESSION["id"] = $row["id_user"];
            $_SESSION["username"] = $username;
            $_SESSION["user_type"] = $row["user_type"];
            header("location: home.php");
        }

        //if there is no result, deny access
        else{
            $error = "Your login credentials are invalid.";
            $allgood = false;
            $_SESSION["login_error"] = $error;
        }
    }
}
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
                    Uporabniško ime
                </div>
                <div>
                    <input type="text" name="username" class="field" id="user_field" required onblur="delete_spaces()">
                </div>
            </div>
            <div class="password">
                <div class="field_title" id="pass_title">
                    <div class="pass_head">
                        Geslo
                    </div>
                    <div class="show_con">
                        <button type="button" class="show_button" id="show_btn" onclick="click_show_button()">Pokaži</button>
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
                <input type="submit" class="submit_btn" value="Prijava">
            </div>
        </div>
        <!--BUTTON-->

    </form>
    <!--MAIN-->

</body>
<!--BODY-->

</html>

<?php
//print out error if there is any
if(isset($_SESSION["login_error"])){
    $error = $_SESSION["login_error"];
    echo "
        <script>
            let error_msg = '$error';
            let error_item = document.getElementById('error_login');
            
            error_item.innerHTML = error_msg;
        </script>
    ";
}
?>