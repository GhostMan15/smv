<?php
include("Scripts/config.php");
session_start();

$error = "";
$allgood = true;

//on submit of form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //get data from form
    $name = mysqli_escape_string($db, $_POST["ime"]);
    $surname = mysqli_escape_string($db, $_POST["priimek"]);
    $password = mysqli_escape_string($db, $_POST["geslo"]);
    $image = $_FILES["image"];

    //get image data
    $image = $_FILES["image"];
    $image_name = $_FILES["image"]["name"];
    $image_temp_name = $_FILES["image"]["tmp_name"];
    $image_size = $_FILES["image"]["size"];
    $image_error = $_FILES["image"]["error"];
    $image_type =  $_FILES["image"]["type"];
    $image_ext = explode(".", $image_name);
    $image_real_ext = strtolower(end($image_ext));

    //supported formats
    $formats = ["jpg", "jpeg", "png", "webp"];
    $numeric = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];

    //check for empty name and surname
    if($name == "" || $surname == ""){
        $error .= "Prosim izpolnite ime in priimek. <br>";
        $allgood = false;
    }

    //check for numeric values in name
    if(preg_match("[0-9]", $name) || preg_match("~[0-9]+~", $surname)){
        $error .= "Vaše ime oz. priimek ne smeta vsebovati številk. <br>";
    }

    //check for an empty pass
    if($password == ""){
        $error .= "Vaše geslo ne sme biti prazno. <br>";
        $allgood = false;
    }

    //check for spaces in pass
    if(str_contains($password, " ")){
        $error .= "Vaše geslo ne sme imeti presledkov <br>";
    }

    //check for correct image format, if there is even an image
    if(!in_array($image_real_ext, $formats) && $image_name != ""){
        $error .= "Slika ni v pravilnem formatu (dovoljeni so samo .jpg, .png, in .webp).";
        $allgood = false;
    }

    //if all is good try to create a new account
    if($allgood){
        //make a new username 
        $full_name = $name . " " . $surname;
        $new_username = ucwords($full_name);
        $new_username = trim($new_username);
        $new_username = str_replace(" ", "", $new_username);

        //check if a user with that same username already exists
        $username_query = "SELECT `username` FROM `user` WHERE `username` = '$new_username';";
        $username_result = mysqli_query($db, $username_query);
        $username_count = mysqli_num_rows($username_result);

        //if the username isnt availible, generate new usernames until one is free (NameSurname1, 2, 3, 4, ...)
        if($username_count != 0){
            $sub_username = "";
            for($i = 1; $username_count != 0; $i++){
                $sub_username = $new_username . "$i";
                $username_query = "SELECT `username` FROM `user` WHERE `username` = '$sub_username';";
                $username_result = mysqli_query($db, $username_query);
                $username_count = mysqli_num_rows($username_result);
            }
            $new_username = $sub_username;
        }

        //insert query - create new account, and get new user's data
        $insert_query = "INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`, `img_ext`) VALUES (DEFAULT, 2, '$name', '$surname', '$password', '$new_username', NULL, NULL);";
        $insert_result = mysqli_query($db, $insert_query);
        $data_query = "SELECT * FROM `user` WHERE `username` = '$new_username';";
        $data_result = mysqli_query($db, $data_query);
        $data_rows = mysqli_fetch_assoc($data_result);

        $message = "Vaše novo uporabniško ime je $new_username. ";

        //check if an image was uploaded
        if($image_temp_name != null && $image_name != ""){
            //assemble new filename
            $img_new_name = "pfp_" . $data_rows['id_user'];
            $img_new_filename = $img_new_name . "." . $image_real_ext;
            $img_root = "Pictures/Profile_Pictures/";
            $img_full_path = $img_root . $img_new_filename;

            //file upload success
            if(move_uploaded_file($image_temp_name, $img_full_path)){
                $img_update_query = "UPDATE `user` SET `img_ext` = '$image_real_ext' WHERE `id_user` = '". $data_rows['id_user'] ."';";
                $img_update_result = mysqli_query($db, $img_update_query);
                $message .= "\nPriloženo sliko smo nastavili kot vašo profilsko sliko. ";
            }

            //file upload fail - set stock pfp as profile picture
            else{
                $stock_path = $img_root . "unknown.jpg";
                //file copy success
                if(copy($stock_path, $img_new_name.".jpg")){
                    $img_update_query = "UPDATE `user` SET `img_ext` = 'jpg' WHERE `id_user` = '". $data_rows['id_user'] ."';";
                    $img_update_result = mysqli_query($db, $img_update_query);
                    $message .= "\nPriložene slike nismo morali obdelati. Zamenjali smo jo s privzeto profilsko sliko. ";
                }
                //file copy fail
                else{
                    $message .= "\nPriložene slike nismo morali obdelati. Pozneje lahko novo sliko naložite na 'Vaš profil' zavihku. ";
                }
            }
            
        }

        //set session state variables
        $_SESSION["id"] = $data_rows['id_user']; 
        $_SESSION["username"] = $new_username;
        $_SESSION["user_type"] = $data_rows['user_type'];

        //display message
        echo "<script>alert($message)</script>";

        //redirect to homepage
        header("location: home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!--HEAD-->
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Mark Sadnik">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheets/register.css">
    <title>Ustvari račun</title>
</head>
<!--HEAD-->

<!--BODY-->
<body>
    <form class="main" method="post" enctype='multipart/form-data'>
        
        <!--TOP-->
        <div class="top">
            <div class="img_con">
                <img class="logo" src="Pictures/logo.png">
            </div>
        </div>
        <!--TOP-->

        <!--MIDDLE-->
        <div class="middle">

            <div class="name">
                <div class="title">
                    Ime<span class="star">*</span>
                </div>
                <div class="name_inner">
                    <input type="text" class="text_field" name="ime" maxlength="50" required> 
                </div>
            </div>

            <div class="surname">
                <div class="title">
                    Priimek<span class="star">*</span>
                </div>
                <div class="surname_inner">
                    <input type="text" class="text_field" name="priimek" maxlength="50" required>
                </div>
            </div>

            <div class="password">
                <div class="title">
                    Geslo<span class="star">*</span>
                </div>
                <div class="password_inner">
                    <input type="password" class="text_field" name="geslo" maxlength="50" placeholder="Brez presledkov, max. 50 črk" required>
                </div>
            </div>

            <div class="picture">
                <div class="pic_inner">
                    <input type="file" class="file_upload" name="image" accept=".png, .jpg, .jpeg, .webp">
                </div>
            </div>
        </div>
        <!--MIDDLE-->

        <!--BOTTOM-->
        <div class="bottom">
            <div class="error">
                <?php
                echo $error;
                ?>
            </div>
            <div class="login_text">Že imaš račun? Prijavi se <a href="login.php" class="link">tukaj</a>.</div>
            <div class="submit">
                <input type="submit" class="submit_btn" value="Registriraj"> 
            </div>
        </div>
        <!--BOTTOM-->

    </form>
</body>
<!--BODY-->

</html>