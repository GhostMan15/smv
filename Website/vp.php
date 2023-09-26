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
    $user_type =  $_SESSION["user_type"];
}

$_SESSION['profile_error'] = "";
$error = "";
$allgood = true;

//on save changes
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id == $_GET['id']) {
    //get form text data
    $password = mysqli_escape_string($db, $_POST['password']);
    $more = mysqli_escape_string($db, $_POST['opis']);

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

    //Check for an empty password
    if($password == ""){
        $error = "Vaše novo geslo ne sme biti prazno. <br>";
        $allgood = false;
    }

    //Check for spaces in password 
    if(str_contains($password, " ")){
        $error .= "Vaše geslo ne sme vsebovati presledkov. <br>";
        $allgood = false;
    }   

    //check if an uploaded image is of the right format
    if(!in_array($image_real_ext, $formats) && $image_name != ""){
        $error .= "Slika ni v pravilnem formatu (dovoljeni so samo .jpg, .png, in .webp).";
        $allgood = false;
    }

    //If all is good, try to save data and profile picture
    if($allgood){
        //save text data into db
        $update_query = "UPDATE `user` SET `geslo` = '$password', `opis` = '$more' WHERE `id_user` = '$id';";
        $update_result = mysqli_query($db, $update_query);

        //save picture if a user uploaded it, and it has no error
        if($image_temp_name != null && $image_name != ""){
            //get old user data - image type
            $sql_query = "SELECT * FROM `user` WHERE `id_user` = '" . $_GET['id'] . "';";
            $sql_result = mysqli_query($db, $sql_query);
            $returned_rows = mysqli_fetch_assoc($sql_result);
            
            //assemble new filename
            $img_new_name = "pfp_" . $id;
            $img_new_filename = $img_new_name . "." . $image_real_ext;
            $img_root = "Pictures/Profile_Pictures/";
            $img_full_path = $img_root . $img_new_filename;
            
            //delete old pfp
            if(file_exists($img_root . $img_new_name . "." . $returned_rows['img_ext'])){
                unlink($img_root . $img_new_name . "." . $returned_rows['img_ext']);
            }

            //file upload success
            if(move_uploaded_file($image_temp_name, $img_full_path)){
                $img_update_query = "UPDATE `user` SET `img_ext` = '$image_real_ext' WHERE `id_user` = '$id';";
                $img_update_result = mysqli_query($db, $img_update_query);
            }

            //file upload fail - set stock pfp as profile picture
            else{
                $stock_path = $img_root . "unknown.jpg";
                //file copy success
                if(copy($stock_path, $img_new_name.".jpg")){
                    $img_update_query = "UPDATE `user` SET `img_ext` = 'jpg' WHERE `id_user` = '$id';";
                    $img_update_result = mysqli_query($db, $img_update_query);
                }
                //file copy fail
                else{
                    $error .= "Nadomestne slike ni šlo naložiti. Se opravičujemo za napako. <br>";
                }
            }
            
        }
    }
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
                    <li> <a href='users.php'>Uporabniki</a></li>
                    <li id='checked'> <a href='vp.php'>Vaš Profil</a></li>
                    <li> <a href='login.php'>Odjava</a></li>
                </ul>
                ";
            }    
        ?>
        </div>




        <!--EDIT MODE-->
        <form class="contentVP" enctype='multipart/form-data' action='' method='post'>

        <?php
            //check if the user id is defined in the link
            if (isset($_GET['id'])) {
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
                        <div class='img_wrap'>";

                    //if the user has a profile picture, display it
                    if($returned_rows["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_". $_GET['id'] . "." . $returned_rows["img_ext"])){
                        echo "<img class='vp_pfp' src='Pictures/Profile_Pictures/pfp_". $_GET['id'] . "." . $returned_rows["img_ext"] . "'>";
                    }
                    //if the user doesn't have a picture, display stock pfp
                    else{
                        echo "<img class='vp_pfp' src='Pictures/Profile_Pictures/unknown.jpg'>";
                    }

                    echo"   </div>
                        </div>
                        <!--TITLE-->
                        ";

                    //edit mode
                    if($_GET['id'] == $id){
                        echo"
                        <!--DETAILS-->
                        <div class='user_info'>
                            <div class='identity'>
                                <div class='left title'>Ime in priimek:</div>
                                <div class='right name_inner'>" . $returned_rows['ime'] . ", " . $returned_rows['priimek'] . "</div>
                            </div>
                            <!--
                            <div class='pfp'>
                                <div class='left title'>Spremeni sliko:</div>
                                <div class='right file_upload'>
                                    <input type='file' name='image' class='file_upload' accept='.png, .jpeg, .jpg, .webp'>
                                </div>
                            </div>
                            -->
                            <div class='password'>
                                <div class='left title'>Geslo:</div>
                                <div class='pass_wrap right'>
                                    <input name='password' type='password' value='" . $returned_rows["geslo"] . "' class='input_field normal_field' onfocus='on_change(1)' onblur='on_change(2)' oninput='passwordFieldWidth()' id='pass_field' maxlength='50' required>
                                    <button type='button' id='show_btn' class='show_button' onclick='click_show_button()'>Pokaži</button>
                                    <script defer>
                                        passwordFieldWidth();
                                    </script>
                                </div>
                            </div>
                            <div class='pfp'>
                                <div class=''>
                                    <input type='file' name='image' class='file_upload' accept='.png, .jpeg, .jpg, .webp'>
                                </div>
                            </div>
                            <!--
                            <div class='password'>
                                <div class='left title'>Geslo:</div>
                                <div class='pass_wrap right'>
                                    <input name='password' type='password' value='" . $returned_rows["geslo"] . "' class='input_field normal_field' onfocus='on_change(1)' onblur='on_change(2)' oninput='passwordFieldWidth()' id='pass_field' maxlength='50' required>
                                    <button type='button' id='show_btn' class='show_button' onclick='click_show_button()'>Pokaži</button>
                                    <script defer>
                                        passwordFieldWidth();
                                    </script>
                                </div>
                            </div>
                            -->
                            <div class='teachers'>
                                <div class='title'>Profesorji:</div>
                                <div>
                                    <ul class='list_prof'>    
                                        <li>Koren</li>
                                        <li>Koren</li>
                                    </ul>
                                </div>
                            </div>
                            <div class='about title'>
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
                            <div class='identity'>
                                <div class='left title'>Ime in priimek:</div>
                                <div class='right name_inner'>" . $returned_rows['ime'] . ", " . $returned_rows['priimek'] . "</div>
                            </div>
                            <div class='teachers'>
                                <div class='title'>Profesorji:</div>
                                <div>
                                    <ul class='list_prof'>    
                                        <li>Koren</li>
                                        <li>Koren</li>
                                    </ul>
                                </div>
                            </div>
                            <div class='about'>
                                <div class='title'>Več o uporabniku:</div>
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
            //if not, redirect to own profile
            else{
                header("location: vp.php?id=" . $id);
            }
            ?>

        </form>
        <!--EDIT MODE-->



        <!--ERROR-->
        <div class="error">
        <?php
            echo $error;
        ?>
        </div>

    
        <!--ERROR-->
    </div>

</body>
</html>