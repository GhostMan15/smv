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

    //set user type - student (2)
    $level = 2;
    if(isset($_POST["level"])){
        $level = mysqli_escape_string($db, $_POST["level"]);
    }

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
    $numeric = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $specials = ["č", "Č", "š", "Š", "ž", "Ž", "ć", "Ć"];

    
    //check for empty name and surname
    if($name == "" || $surname == ""){
        $error .= "Prosim izpolnite ime in priimek. <br>";
        $allgood = false;
    }

    //check for numeric values in name and surname
    $isNumeric = false;

    for($i = 0; $i < strlen($name); $i++){
        for($j = 0; $j < count($numeric); $j++){
            if($name[$i] == $numeric[$j]){
                $isNumeric = true;
                break;
            }
        }
    }

    for($i = 0; $i < strlen($surname); $i++){
        for($j = 0; $j < count($numeric); $j++){
            if($surname[$i] == $numeric[$j]){
                $isNumeric = true;
                break;
            }
        }
    }

    if($isNumeric){
        $error .= "Vaše ime oz. priimek ne smeta vsebovati številk. <br>";
        $allgood = false;
    }


    //check for an empty pass
    if($password == ""){
        $error .= "Vaše geslo ne sme biti prazno. <br>";
        $allgood = false;
    }

    //check for spaces in pass
    if(str_contains($password, " ")){
        $error .= "Vaše geslo ne sme imeti presledkov <br>";
        $allgood = false;
    }


    //check minimum password specifications - at least 12 chars, one uppercase letter, one number
    if(strlen($password) < 12){
        $allgood = false;
        $error .= "Vaše geslo mora vsebovati vsaj 12 znakov.";
    }

    $containsNumber = false; 
    $containsUppercase = false;
    $containsSpecials = false;

    for($i = 0; $i < strlen($password); $i++){
        
        for($j = 0; $j < count($numeric); $j++){
            if($password[$i] == $numeric[$j]){
                $containsNumber = true;
            }
        }

        /*
        for($k = 0; $k < count($specials); $k++){
            if($password[$i] == $specials[$k]){
                $containsSpecials = true;
                break;
            }
        }
        */

        if(ctype_upper($password[$i])){
            $containsUppercase = true;
        }
    }

    if($containsNumber == false){
        $allgood = false;
        $error .= "Vaše geslo mora imeti vsaj eno številko. <br>";
    }

    if($containsUppercase == false){
        $allgood = false;
        $error .= "Vaše geslo mora vsebovati vsaj eno veliko črko. <br>";
    }

    /*
    if($containsSpecials){
        $allgood = false;
        $error .= "Vaše geslo ne sme vsebovati šumnikov. <br>";
    }
    */


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

        //hash password
        $hash_pass = password_hash($password, PASSWORD_DEFAULT);

        //insert query - create new account, and get new user's data
        $insert_query = "INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`, `img_ext`) VALUES (DEFAULT, '$level', '$name', '$surname', '$hash_pass', '$new_username', NULL, NULL);";
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

        //set session state variables, if the logged in user isn't an admin
        /*if(!isset($_SESSION["user_type"])){
            
        }*/

        $_SESSION["id"] = $data_rows['id_user']; 
        $_SESSION["username"] = $new_username;
        $_SESSION["user_type"] = $data_rows['user_type'];
        $_SESSION['pass'] = $password;
    
        //pass message through session to home.php
        $_SESSION["register_message"] = $message;

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
                <div class="pass_top">
                    <div class="title pass_title">
                        Geslo<span class="star">*</span>
                    </div>
                    <div class="show_con">
                        <button type="button" class="show_button" id="show_btn" onclick="click_show_button()">Pokaži</button>
                    </div>
                </div>
                <div class="password_inner">
                    <input type="password" class="text_field" id='pass_field' name="geslo" maxlength="50" placeholder="min. 12 črk, 1 velika črka in številka, brez šumnikov" required>
                </div>
            </div>

            <div class="picture">
                <div class="pic_inner">
                    <input type="file" class="file_upload" name="image" accept=".png, .jpg, .jpeg, .webp">
                </div>
            </div>
            
            <?php
            //if user is admin - render dropdown
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];

                $type_query = "SELECT * FROM `user` WHERE `id_user` = '$id';";
                $type_result = mysqli_query($db, $type_query);
                $type_assoc = mysqli_fetch_assoc($type_result);
                $user_type = $type_assoc['user_type'];
                $_SESSION["user_type"] = $user_type;

                if($user_type == 0){
                    echo"
                    <div class='level'>
                        <div class='title'>
                            Nivo:
                            <select name='level' class='level_dropdown'>
                                <option value='2'>Učenec</option>
                                <option value='1'>Profesor</option>
                            </select>
                        </div>
                    </div>
                    ";
                }
            }    
            ?>

        </div>
        <!--MIDDLE-->

        <!--BOTTOM-->
        <div class="bottom">
            <div class="error">
                <?php
                echo $error;
                ?>
            </div>
            <div class="login_text">
                <p>Že imaš račun? Prijavi se <a href="login.php" class="link">tukaj</a>.</p>
            </div>
            <div class="submit">
                <input type="submit" class="submit_btn" value="Registriraj"> 
            </div>
        </div>
        <!--BOTTOM-->

    </form>

    <script src="Scripts/login.js"></script>
</body>
<!--BODY-->

</html>