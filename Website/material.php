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

$allgood = true;
$error = "";

//on form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_gradiva = $_GET['gradivo']; 

    //get file data
    $file = $_FILES["file"];
    $file_name = $_FILES["file"]["name"];
    $file_temp_name = $_FILES["file"]["tmp_name"];
    $file_size = $_FILES["file"]["size"];
    $file_error = $_FILES["file"]["error"];
    $file_type =  $_FILES["file"]["type"];
    $file_ext = explode(".", $file_name);
    $file_real_ext = strtolower(end($file_ext));

    //not supported
    $not_supported = ["exe", "ini", "dll"];

    /*----------------------------------student----------------------------------*/
    if($user_type == 2){
        //check if user uploaded the file
        if($file_temp_name != null && $file_name != ""){
            //check file type
            for($i = 0; $i < count($not_supported); $i++){
                if($file_real_ext == $not_supported[$i]){
                    $allgood = false;
                    $error .= "Oddana datoteka imeta nedovoljeno končnico <br>";
                    break;
                }
            }

            //check file size
            if($file_size > 10000000){
                $allgood = false;
                $error .= "Oddana datoteka ne sme presegati 10MB velikosti. <br>";
            }

            //if all is good try to upload
            if($allgood){
                $upload_query = "SELECT * FROM `oddaja` WHERE `id_user` = '$id' AND `id_gradiva` = '$id_gradiva'";
                $upload_result = mysqli_query($db, $upload_query);
                $upload_rows = mysqli_fetch_assoc($upload_result);
                $upload_count = mysqli_num_rows($upload_result);

                //if the user hasnt uploaded a file yet, carry out insert into
                if($upload_count == 0){
                    $insert_query = "
                    INSERT INTO `oddaja` (`id_oddaja`, `id_gradiva`, `ocena`, `datum_oddaje`, `id_user`, `file_ext`, `priloga`)
                    VALUES (DEFAULT, '$id_gradiva', NULL, CURRENT_DATE(), '$id', '$file_real_ext', '0');
                    ";
                    $insert_result = mysqli_query($db, $insert_query);

                    $new_upload_query = "SELECT * FROM `oddaja` 
                    WHERE `id_user` = '$id'
                    ORDER BY `id_oddaja` DESC;";
                    $new_upload_result = mysqli_query($db, $new_upload_query);
                    $new_upload_rows = mysqli_fetch_assoc($new_upload_result);

                    $new_id_oddaja = $new_upload_rows['id_oddaja'];
                    $file_full_path = "Files/" . $new_id_oddaja . "." . $file_real_ext;

                    if(!move_uploaded_file($file_temp_name, $file_full_path)){
                        $error .= "Datoteke ni šlo naložiti. Se opravičujemo za napako. <br>";
                    }
                }

                //if the user has uploaded a file already, carry out update
                else{
                    $id_oddaja = $upload_rows['id_oddaja'];
                    $file_full_path = "Files/" . $id_oddaja . "." . $upload_rows['file_ext'];
                    if(move_uploaded_file($file_temp_name, $file_full_path)){
                        $update_query = "UPDATE `oddaja`
                        SET `ocena` = NULL, `datum_oddaje` = CURRENT_DATE(), `file_ext` = '$file_real_ext', `komentar` = NULL
                        WHERE `id_oddaja` = '$id_oddaja';
                        ";
                    }
                    else{
                        $error .= "Datoteke ni šlo naložiti. Se opravičujemo za napako. <br>";
                    }
                }
            }
        }
    }
    /*----------------------------------student----------------------------------*/


    /*----------------------------------admin, teacher----------------------------------*/
    else{
        //get form text data
        $title = mysqli_escape_string($db, $_POST['title']);
        $title = trim($title);
        $description = mysqli_escape_string($db, $_POST['description']);
        $description = trim($description);
        
        //check proper string lengths and that they are not empty
        if(strlen($description) > 1024){
            $allgood = false;
            $error .= "Opis naloge ne sme biti daljši od 1024 znakov <br>";
        }
        else if(strlen($title) > 50){
            $allgood = false;
            $error .= "Naslov naloge ne sme biti daljši od 50 znakov <br>";
        }
        else if(trim($description) == "" || trim($title) == ""){
            $allgood = false;
            $error .= "Naslov in opis naloge ne smeta biti prazna <br>";
        }
        

        //if all is good do updates and upload files if there was any
        if($allgood){
            //update description, title, and date
            if(isset($_POST['date_due'])){
                $date_due = mysqli_escape_string($db, $_POST['date_due']);
                $gradivo_update = "UPDATE `gradiva`
                SET `naslov` = '$title', `opis` = '$description', `datum_do` = '$date_due' 
                WHERE `id_gradiva` = '$id_gradiva';
                ";
            }
            else{
                $gradivo_update = "UPDATE `gradiva`
                SET `naslov` = '$title', `opis` = '$description'
                WHERE `id_gradiva` = '$id_gradiva';";
            }
            
            $gradivo_result = mysqli_query($db, $gradivo_update);

            //check if teacher uploaded the file
            if($file_temp_name != null && $file_name != ""){
                //check file type
                for($i = 0; $i < count($not_supported); $i++){
                    if($file_real_ext == $not_supported[$i]){
                        $allgood = false;
                        $error .= "Oddana datoteka imeta nedovoljeno končnico <br>";
                        break;
                    }
                }

                //check file size
                if($file_size > 10000000){
                    $allgood = false;
                    $error .= "Oddana datoteka ne sme presegati 10MB velikosti. <br>";
                }

                //if all is good try to upload
                if($allgood){
                    $upload_query = "SELECT * FROM `oddaja` WHERE `id_user` = '$id' AND `id_gradiva` = '$id_gradiva'";
                    $upload_result = mysqli_query($db, $upload_query);
                    $upload_rows = mysqli_fetch_assoc($upload_result);
                    /*$upload_count = mysqli_num_rows($upload_result);*/

                    $insert_query = "
                    INSERT INTO `oddaja` (`id_oddaja`, `id_gradiva`, `ocena`, `datum_oddaje`, `id_user`, `file_ext`, `priloga`)
                    VALUES (DEFAULT, '$id_gradiva', NULL, CURRENT_DATE(), '$id', '$file_real_ext', '1');
                    ";
                    $insert_result = mysqli_query($db, $insert_query);

                    $new_upload_query = "SELECT * FROM `oddaja` 
                    WHERE `id_user` = '$id'
                    ORDER BY `id_oddaja` DESC;"
                    ;
                    $new_upload_result = mysqli_query($db, $new_upload_query);
                    $new_upload_rows = mysqli_fetch_assoc($new_upload_result);

                    $new_id_oddaja = $new_upload_rows['id_oddaja'];
                    $file_full_path = "Files/" . $new_id_oddaja . "." . $file_real_ext;

                    if(!move_uploaded_file($file_temp_name, $file_full_path)){
                        $error .= "Datoteke ni šlo naložiti. Se opravičujemo za napako. <br>";
                    }    
                }
            }

        }
    }
    /*----------------------------------admin, teacher----------------------------------*/
}
?>

<!DOCTYPE html>
<html lang='en'>
<!--HEAD-->

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Gradivo</title>
    <link rel='stylesheet' type='text/css' href='Stylesheets/material.css'>
    <script src='Scripts/material.js'></script>
</head>
<!--HEAD-->

<body>

    <!--MAIN-->
    <div class='main'>

        <!--NAV-->
        <div class='navbar_div'>
            <div class='navbar'>
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
                        <li><a href='redovalnica.php'>Ocene</a></li>
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
        <form class='container' enctype='multipart/form-data' action='' method='post'>
            <div class='content'>

            <?php
            if(isset($_GET['gradivo'])){

                //query for data in tables gradiva, model, predmeti
                $id_gradiva = $_GET['gradivo']; 
                $gradivo_query = "SELECT `g`.*, `m`.`id_modula` AS `m_id_modula`, `p`.`id_predmet` AS `p_id_predmet`, `p`.`ime` AS `p_ime` 
                FROM `gradiva` `g` JOIN `model` `m`
                ON `m`.`id_modula` = `g`.`id_modula` JOIN `predmeti` `p`
                ON `p`.`id_predmet` = `m`.`id_predmet`
                WHERE `g`.`id_gradiva` = '$id_gradiva'";
                $gradivo_result = mysqli_query($db, $gradivo_query);
                $gradivo_count = mysqli_num_rows($gradivo_result);
                
                /*echo"<script>alert('ba');</script>";*/

                //result found
                if($gradivo_count != 0){
                    $row = mysqli_fetch_assoc($gradivo_result);
                    $oddaja = $row['oddaja'];
                    
                    //check if logged in user is indeed part of the subject
                    $id_predmet = $row["p_id_predmet"];
                    $user_exists_query = "SELECT `u`.*
                    FROM `predmeti` `p` JOIN `ucilnica` `u`
                        ON `p`.`id_predmet` = `u`.`id_predmet`
                    WHERE `p`.`id_predmet` = '$id_predmet'
                    AND `u`.`id_user` = '$id';
                    ";
                    $user_exists_result = mysqli_query($db, $user_exists_query);
                    $user_exists_count = mysqli_num_rows($user_exists_result);

                    //*-------------------------------ADMIN, TEACHERS-------------------------------*/
                    if($user_type == 0 || ($user_exists_count != 0 && $user_type == 1)){

                        //TOP - ADMINS
                        echo"
                        <!--TOP-->        
                        <div class='top'>     
                            <div class='title_con' id='title_div'>
                                <input type='text' name='title' class='title' value='".$row["naslov"]."' required maxlength='50' id='title_field' onfocus='on_change(1)' onblur='on_change(2)'>
                            </div>
                            <div class='subject_con title'>
                                ".$row["p_ime"]."
                            </div>
                        </div>
                        <!--TOP-->
                        ";


                        //MIDDLE - ADMIN
                        echo"
                        <!--MID-->
                        <div class='mid'>
                            <div class='text_con'>
                                <textarea name='description' id='textarea_field' required placeholder='vpišite besedilo...' oninput='textAreaSize()' onfocus='on_change(3)' onblur='on_change(4)'>".$row["opis"]."</textarea>
                            </div>
                        </div>
                        <!--MID-->
                        ";

                        //BOTTOM - ADMIN
                        echo"
                        <!--BOTTOM-->
                        <div class='bottom'>
                        ";

                        //PRILOGE - ADMIN
                        $priloge_query = "SELECT * FROM `oddaja` WHERE `id_gradiva` = '$id_gradiva' AND `priloga` = '1';";
                        $priloge_result = mysqli_query($db, $priloge_query);
                        $priloge_count = mysqli_num_rows($priloge_result);

                        if($priloge_count != 0){
                            //create variable for counting the attachments
                            $i = 1;
                            //$containedFiles = false;

                            while($priloge_row = mysqli_fetch_assoc($priloge_result)){
                                $filename = "Files/" . $priloge_row['id_oddaja'] . "." . $priloge_row['file_ext'];

                                if(file_exists($filename)){
                                    if($i == 1){
                                        echo"
                                        <!--PRILOGE-->
                                        <div class='title2'>Priloge</div>
                                        <div class='prof_files'>
                                        ";
                                        //$containedFiles = true;
                                    }

                                    echo"
                                        <div class='prof_row'>
                                    ";

                                    if($priloge_row['file_ext'] == 'png' || $priloge_row['file_ext'] == 'jpg' || $priloge_row['file_ext'] == 'jpeg' || $priloge_row['file_ext'] == 'webp' || $priloge_row['file_ext'] == 'jfif' || $priloge_row['file_ext'] == 'gif'){
                                        echo"
                                        <img src='Pictures/img_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$priloge_row['id_oddaja']."' class='delete_text'>(-)</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'pdf'){
                                        echo"
                                        <img src='Pictures/pdf_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$priloge_row['id_oddaja']."' class='delete_text'>(-)</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'zip' || $priloge_row['file_ext'] == 'rar' || $priloge_row['file_ext'] == '7z'){
                                        echo"
                                        <img src='Pictures/zip_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$priloge_row['id_oddaja']."' class='delete_text'>(-)</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'docx' || $priloge_row['file_ext'] == 'doc'){
                                        echo"
                                        <img src='Pictures/doc_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$priloge_row['id_oddaja']."' class='delete_text'>(-)</a>
                                        ";
                                    }

                                    else{
                                        echo"
                                        <img src='Pictures/file_default.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$priloge_row['id_oddaja']."' class='delete_text'>(-)</a>
                                        ";
                                    }
                                        
                                    echo"
                                        </div>
                                    ";

                                    $i++;
                                }
                            }

                            if($i > 1){
                                echo"
                                </div>
                                <!--PRILOGE-->
                                ";
                            }
                        }
                        

                        //STANJE NALOGE - ADMIN
                        if($oddaja == 1){
                            echo"
                            <!--STANJE ODDAJE-->
                            <div class='title2'>Stanje naloge</div>
                            <table class='table'>
                            ";

                            echo"
                            <tr class='submission'>
                                <td class='t_left'>
                                    Stanje oddaj
                                </td> 
                            ";

                            $oddano_query = "SELECT DISTINCT `id_user` FROM `oddaja` WHERE `id_gradiva` = '$id_gradiva' AND `priloga` = '0';";
                            $oddano_result = mysqli_query($db, $oddano_query);
                            $oddano_count = mysqli_num_rows($oddano_result);

                            //oddane naloge
                            if($oddano_count > 0){
                                echo"
                                <td class='submit_status'>
                                    $oddano_count oddanih <sup><a class='download_link accepted' href='grades.php?gradivo='$id_gradiva'>(Ogled)</a></sup>
                                </td>
                                </tr>
                            ";
                            }

                            //nobene oddane
                            else{
                                echo"
                                <td class='submit_status'>
                                    $oddano_count oddanih
                                </td>
                                </tr>
                            ";
                            }
                            

                            echo"
                            <tr class='due'>
                                <td class='t_left bottom_row'>
                                    Rok oddaje
                                </td>
                                <td class='date_due bottom_row'>
                                    <input type='date' required class='date_picker' name='date_due' value='". $row["datum_do"] ."'>
                                </td>
                            </tr>
                            </table>
                            ";
                        }
                        

                        //DODAJ PRILOGO
                        echo"
                        <!--DODAJ PRILOGO-->
                        <div class='submit_title'>
                            <div class='title2'>Dodaj prilogo</div>
                            <div class='accepted'>(največ 10MB)</div>
                        </div>
                        
                        <div class='submit_con'>
                            <div class='file_upload_con'>
                                <input type='file' name='file' class='file_upload'>
                            </div>
                            <div class='submit_btn_con'>
                                <input type='submit' class='submit_btn' value='Shrani spremembe'>
                            </div>
                        </div>
                        <!--ODDAJA-->
                        ";


                        echo"
                        </div>
                        <!--BOTTOM-->
                        ";

                    }
                    /*-------------------------------ADMIN, TEACHERS-------------------------------*/

                    /*-------------------------------STUDENTS-------------------------------*/
                    else if(($user_exists_count != 0 && $user_type == 2)){
                        //TOP - STUDENTS
                        echo"
                        <!--TOP-->        
                        <div class='top'>     
                            <div class='title_con' id='title_div'>
                                <input type='text' name='title' class='title' value='".$row["naslov"]."' readonly required maxlength='50' id='title_field' onfocus='on_change(1)' onblur='on_change(2)'>
                            </div>
                            <div class='subject_con title'>
                                MAT
                            </div>
                        </div>
                        <!--TOP-->
                        ";

                        //MIDDLE - STUDENTS
                        echo"
                        <!--MID-->
                        <div class='mid'>
                            <div class='text_con'>
                                <textarea name='description' id='textarea_field' readonly required placeholder='vpišite besedilo...' oninput='textAreaSize()' onfocus='on_change(3)' onblur='on_change(4)'>".$row["opis"]."</textarea>
                            </div>
                        </div>
                        <!--MID-->
                        ";

                        //BOTTOM - STUDENTS
                        echo"
                        <!--BOTTOM-->
                        <div class='bottom'>
                        ";

                        //PRILOGE - STUDENTS
                        $priloge_query = "SELECT * FROM `oddaja` WHERE `id_gradiva` = '$id_gradiva' AND `priloga` = '1';";
                        $priloge_result = mysqli_query($db, $priloge_query);
                        $priloge_count = mysqli_num_rows($priloge_result);

                        if($priloge_count != 0){
                            $i = 1;
                            while($priloge_row = mysqli_fetch_assoc($priloge_result)){
                                $filename = "Files/" . $priloge_row['id_oddaja'] . "." . $priloge_row['file_ext'];

                                if(file_exists($filename)){
                                    if($i == 1){
                                        echo"
                                        <!--PRILOGE-->
                                        <div class='title2'>Priloge</div>
                                        <div class='prof_files'>
                                        ";
                                    }

                                    echo"
                                        <div class='prof_row'>
                                    ";

                                    if($priloge_row['file_ext'] == 'png' || $priloge_row['file_ext'] == 'jpg' || $priloge_row['file_ext'] == 'jpeg' || $priloge_row['file_ext'] == 'webp' || $priloge_row['file_ext'] == 'jfif' || $priloge_row['file_ext'] == 'gif'){
                                        echo"
                                        <img src='Pictures/img_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'pdf'){
                                        echo"
                                        <img src='Pictures/pdf_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'zip' || $priloge_row['file_ext'] == 'rar' || $priloge_row['file_ext'] == '7z'){
                                        echo"
                                        <img src='Pictures/zip_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a>
                                        ";
                                    }

                                    else if($priloge_row['file_ext'] == 'docx' || $priloge_row['file_ext'] == 'doc'){
                                        echo"
                                        <img src='Pictures/doc_file.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a>
                                        ";
                                    }

                                    else{
                                        echo"
                                        <img src='Pictures/file_default.png' class='file_icon'> <a href='$filename' class='download_link' download='Priloga_$i'>Priloga_$i.". $priloge_row['file_ext'] ."</a>
                                        ";
                                    }
                                        
                                    echo"
                                        </div>
                                    ";

                                    $i++;
                                }
                            }
                            if($i > 1){
                                echo"
                                </div>
                                <!--PRILOGE-->
                                ";
                            }
                        }
                        
                        //STANJE NALOGE - STUDENTS
                        if($oddaja == 1){
                            $oddano_query = "SELECT `o`.*, `us`.`ime`, `us`.`priimek` 
                            FROM `oddaja` `o` JOIN `user` `us`
                                ON `o`.`id_user` = `us`.`id_user` 
                            WHERE `id_gradiva` = '$id_gradiva' 
                            AND `id_user` = '$id';
                            ";
                            $oddano_result = mysqli_query($db, $oddano_query);
                            $oddano_count = mysqli_num_rows($oddano_result);
                            $oddano_row = mysqli_fetch_assoc($oddano_result);
                            $filename = "Files/". $oddano_row['id_oddaja'] . "." . $oddano_row['file_ext'];

                            //oddana naloga
                            if($oddano_count > 0 && file_exists($filename)){
                                $download_name = $oddano_row['ime'] . $oddano_row['priimek'] . "-" . $row["naslov"];
                                //$oddano_row = mysqli_fetch_assoc($oddano_result);
                                $raw_date = $row['datum_do'];
                                $split_date = explode("-", $raw_date);
                                $new_date = $split_date[2] . ". " . $split_date[1] . ". " . $split_date[0]; 

                                $raw_add_date = $oddano_row["datum_oddaje"];
                                $split_add_date = explode("-", $raw_date);
                                $new_add_date = $split_date[2] . ". " . $split_date[1] . ". " . $split_date[0]; 
                                
                                echo"
                                <!--STANJE ODDAJE-->
                                <div class='title2'>Stanje naloge</div>
                                <table class='table'>
                                    <tr class='submission'>
                                        <td class='t_left'>
                                            Stanje
                                        </td> 
                                        <td class='submit_status submitted_text'>
                                            Oddano
                                        </td>
                                    </tr>
                                    <tr class='due'>
                                        <td class='t_left'>
                                            Rok oddaje
                                        </td>
                                        <td class='date_due'>
                                            $new_date
                                        </td>
                                    </tr>
                                    <tr class='date_added'>
                                        <td class='t_left'>
                                            Datum oddaje
                                        </td>
                                        <td class='date_added'>
                                            $new_add_date
                                        </td>
                                    </tr>
                                    <tr class='mark'>
                                        <td class='t_left bottom_row'>
                                            Ocena
                                        </td>
                                ";
                                if($oddano_row["ocena"] != ""){
                                    echo"
                                        <td class='bottom_row'>
                                            ". $oddano_row["ocena"]  ." / 100
                                        </td>
                                    </tr>
                                    ";
                                }
                                else{
                                    echo"
                                        <td class='bottom_row'>
                                            Neocenjeno
                                        </td>
                                    </tr>
                                    ";
                                }
                                echo"
                                </table>
                                <!--STANJE ODDAJE-->
                                ";

                                echo"
                                <!--ODDAJA-->
                                <div class='upload_title'>
                                    <div class='title2'>Oddano</div>
                                </div>

                                <div class='student_files'>
                                ";

                                //images
                                if($oddano_row['file_ext'] == 'png'){
                                    echo"
                                    <img src='Pictures/png_file.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }
                                else if($oddano_row['file_ext'] == 'jpg' || $oddano_row['file_ext'] == 'jpeg' || $oddano_row['file_ext'] == 'gif' || $oddano_row['file_ext'] == 'jfif' || $oddano_row['file_ext'] == 'webp'){
                                    echo"
                                    <img src='Pictures/img_file.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }
                                //compressed formats
                                else if($oddano_row['file_ext'] == 'zip' || $oddano_row['file_ext'] == '7z' ||  $oddano_row['file_ext'] == 'rar' || $oddano_row['file_ext'] == 'tar' || $oddano_row['file_ext'] == 'gz'){
                                    echo"
                                    <img src='Pictures/zip_file.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }

                                //pdf, documents
                                else if($oddano_row['file_ext'] == 'pdf'){
                                    echo"
                                    <img src='Pictures/pdf_file.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }
                                else if($oddano_row['file_ext'] == 'doc' || $oddano_row['file_ext'] == 'docx' || $oddano_row['file_ext'] == 'odt'){
                                    echo"
                                    <img src='Pictures/doc_file.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }

                                //others
                                else{   
                                    echo"
                                    <img src='Pictures/file_default.png' class='file_icon'> <a href='$filename' class='download_link' download='$download_name'>$download_name.". $oddano_row['file_ext'] ."</a> <a href='Scripts/delete.php?type=1&id=".$oddano_row['id_oddaja']."' class='delete_text'>(-)</a>
                                    ";
                                }

                                echo"

                                </div>

                                <div class='submit_title'>
                                    <div class='title2'>Ponovna oddaja</div>
                                    <div class='accepted'>(največ 10MB)</div>
                                </div>";
                                
                            }

                            //neoddana naloga
                            else{
                                $oddano_row = mysqli_fetch_assoc($oddano_result);
                                $raw_date = $row['datum_do'];
                                $split_date = explode("-", $raw_date);
                                $new_date = $split_date[2] . ". " . $split_date[1] . ". " . $split_date[0]; 
                                
                                echo"
                                <!--STANJE ODDAJE-->
                                <div class='title2'>Stanje naloge</div>
                                <table class='table'>
                                    <tr class='submission'>
                                        <td class='t_left'>
                                            Stanje
                                        </td> 
                                        <td class='submit_status submitted_text'>
                                            Neoddano
                                        </td>
                                    </tr>
                                    <tr class='due'>
                                        <td class='t_left'>
                                            Rok oddaje
                                        </td>
                                        <td class='date_due'>
                                            $new_date
                                        </td>
                                    </tr>
                                    <tr class='date_added'>
                                        <td class='t_left'>
                                            Datum oddaje
                                        </td>
                                        <td class='date_added'>
                                            \
                                        </td>
                                    </tr>
                                    <tr class='mark'>
                                        <td class='t_left bottom_row'>
                                            Ocena
                                        </td>
                                        <td class='bottom_row'>
                                            \
                                        </td>
                                    </tr>
                                </table>
                                <!--STANJE ODDAJE-->
                                ";     
                                
                                echo"
                                <!--ODDAJA-->
                                <div class='submit_title'>
                                    <div class='title2'>Oddaja</div>
                                    <div class='accepted'>(največ 10MB)</div>
                                </div>";
                            }

                            //ODAJA NALOGE
                            echo"
                            <div class='submit_con'>
                                <div class='file_upload_con'>
                                    <input type='file' name='file' required class='file_upload'>
                                </div>
                                <div class='submit_btn_con'>
                                    <input type='submit' class='submit_btn' value='Oddaj'>
                                </div>
                            </div>
                            <!--ODDAJA-->";
                        }

                        echo"
                        </div>
                        <!--BOTTOM-->
                        ";
                    } 
                    /*-------------------------------STUDENTS-------------------------------*/

                    else{
                        header("location: class.php");
                    }
                }

                else{
                    header("location: class.php");
                }

            }
            else{
                header("location: class.php");
            }
            ?>

            
                <!--   
                    TOP
                <div class='top'>     
                    <div class='title_con' id='title_div'>
                        <input type='text' name='title' class='title' value='Naloga1' required maxlength='50' id='title_field' onfocus='on_change(1)' onblur='on_change(2)'>
                    </div>
                    <div class='subject_con title'>
                        MAT
                    </div>
                </div>
                    TOP

                    MID
                <div class='mid'>
                    <div class='text_con'>
                        <textarea name='description' id='textarea_field' required placeholder='vpišite besedilo...' oninput='textAreaSize()' onfocus='on_change(3)' onblur='on_change(4)'></textarea>
                    </div>
                </div>
                    MID


                    BOTTOM
                <div class='bottom'>


                    <div class='title2'>Priloge</div>
                    <div class='prof_files'>
                        <div class='prof_row'>
                            <img src='Pictures/zip_file.png' class='file_icon'> <a href='$$$' class='download_link'>ZIP_datoteka.zip</a> <a href='delete.php' class='delete_text'>(-)</a>
                        </div>
                        <div class='prof_row'>
                            <img src='Pictures/pdf_file.png' class='file_icon'> <a href='$$$' class='download_link'>PDF_datoteka.pdf</a> <a href='delete.php' class='delete_text'>(-)</a>
                        </div>
                        <div class='prof_row'>
                            <img src='Pictures/file_default.png' class='file_icon'> <a href='Scripts/vp.js' download='PriimekIme-Naloga1' class='download_link'>NEZNANA_datoteka.random_datoteka</a> <a href='delete.php' class='delete_text'>(-)</a>
                        </div>
                    </div>



                    <div class='title2'>Stanje naloge</div>
                    <table class='table'>
                        <tr class='submission'>
                            <td class='t_left'>
                                Stanje
                            </td> 
                            <td class="submit_status">
                                Oddano/Neoddano
                            </td>
                        </tr>
                        <tr class='due'>
                            <td class='t_left'>
                                Rok oddaje
                            </td>
                            <td class='date_due'>
                                <input type='date' class='date_picker' name='date_due'>
                            </td>
                        </tr>
                        <tr class='date_added'>
                            <td class='t_left'>
                                Datum oddaje
                            </td>
                            <td class="date_added">
                                14.10.2023
                            </td>
                        </tr>
                        <tr class='mark'>
                            <td class='t_left bottom_row'>
                                Ocena
                            </td>
                            <td class='bottom_row'>
                                76/100
                            </td>
                        </tr>
                    </table>



                    <div class='submit_title'>
                        <div class='title2'>Oddaja</div>
                        <div class='accepted'>(.zip, največ 10MB)</div>
                    </div>
                    
                    <div class='submit_con'>
                        <div class='file_upload_con'>
                            <input type='file' name="file" class='file_upload'>
                        </div>
                        <div class='submit_btn_con'>
                            <input type='submit' class='submit_btn' value='Oddaj'>
                        </div>
                    </div>

                        -->
                    <!--OGLED ODDAJ-->
                    <!--OGLED ODDAJ
                </div>
                
                BOTTOM-->

            </div>

            <div class='error'>
                <p> 
                    <?php
                    echo $error;
                    ?>
                </p>    
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