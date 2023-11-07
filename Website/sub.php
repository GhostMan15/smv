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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_oddaja = $_GET['oddaja'];
    $grade = mysqli_escape_string($db, $_POST['grade']);
    $comment = mysqli_escape_string($db, $_POST['comment']);
    $comment = trim($comment);

    //check if grade is of correct value
    if($grade > 100 || $grade < 0){
        $allgood = false;
        $error .= "Ocena mora biti od 0 do 100 <br>";
    }

    //check comment length
    if(strlen($comment) > 100){
        $allgood = false;
        $error .= "Komentar mora imeti maksimalno 100 znakov <br>";
    }

    if($allgood){
        $update_query = "
        UPDATE `oddaja`
        SET `ocena` = '$grade', `komentar` =  '$comment'
        WHERE `id_oddaja` = '$id_oddaja';
        ";
        if(!mysqli_query($db, $update_query)){
            $error .= "Podatkov ni šlo posodobiti. Se opravičujemo za napako. <br>";
        }
    }
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
    <form class="container" method="post">

    <?php
    if(isset($_GET['oddaja'])){
        $id_oddaja = $_GET['oddaja'];

        //get submission data
        $oddaja_query = "SELECT `o`.* , `p`.`id_predmet` AS `p_id_predmet`, `g`.*
        FROM `oddaja` `o` JOIN `gradiva` `g`
            ON  `g`.`id_gradiva` = `o`.`id_gradiva` JOIN `model` `m`
            ON `m`.`id_modula` = `g`.`id_modula` JOIN `predmeti` `p`
            ON `p`.`id_predmet` = `m`.`id_predmet`
        WHERE `id_oddaja` = '$id_oddaja';";
        $oddaja_result = mysqli_query($db, $oddaja_query);
        $oddaja_count = mysqli_num_rows($oddaja_result);
        
        //check if submission exists
        if($oddaja_count != 0){
            $oddaja_row = mysqli_fetch_assoc($oddaja_result);
            $id_predmet = $oddaja_row['p_id_predmet'];

            //query to see if user is an admin or professor teaching the subject
            $prof_query = "SELECT `us`.*
            FROM `user` `us` JOIN `ucilnica` `u`
                ON `us`.`id_user` = `u`.`id_user` JOIN `predmeti` `p`
                ON `u`.`id_predmet` = `p`.`id_predmet`
            WHERE `us`.`id_user` = '$id' AND `u`.`user_type` = '1' AND `p`.`id_predmet` = '$id_predmet';
            ";
            $prof_result = mysqli_query($db, $prof_query);
            $prof_count = mysqli_num_rows($prof_result);

            //if rows are returned, display page
            if($user_type == 0 || $prof_count != 0){
                $user_data_query = "SELECT `us`.*, `ocena`, `file_ext`, `komentar`, `datum_oddaje` 
                FROM `user` `us` JOIN `oddaja` `o`
                    ON `us`.`id_user` = `o`.`id_user`
                WHERE `o`.`id_oddaja` = '$id_oddaja';
                ";
                $user_data_result = mysqli_query($db, $user_data_query);
                $user_data_row = mysqli_fetch_assoc($user_data_result);

                //format YYYY-MM-DD
                $raw_date = $user_data_row['datum_oddaje'];
                $split_date = explode("-", $raw_date);
                //fromat DD.MM.YYYY
                $new_date = $split_date[2] . "." . $split_date[1] . "." . $split_date[0]; 

                //TOP
                echo"
                <!--TOP-->
                    <div class='top'>
                        <!--PROFILE-->
                        <div class='profile_con left'>
                            <div>
                ";

                if($user_data_row["img_ext"] != "" && file_exists("Pictures/Profile_Pictures/pfp_" . $user_data_row["id_user"] .".". $user_data_row["img_ext"])){
                    echo"
                                <img src='Pictures/Profile_Pictures/pfp_" . $user_data_row["id_user"] .".". $user_data_row["img_ext"] ."' class='pfp_img'> 
                    ";
                }
                else{
                    echo"
                                <img src='Pictures/unknown.jpg' class='pfp_img'> 
                    ";
                }      
                echo"
                            </div>
                            <div class='username'>". $user_data_row["username"] ."</div>     
                        </div>
                        <!--PROFILE-->

                        <!--OCENA-->
                        <div class='grade_con right'>
                            <span class='title'>Ocena:</span> <input type='number' name='grade' class='grade_input' value='" . $user_data_row["ocena"] ."' max='100' maxlength='3' id='grade_input' onfocus='on_change(1)' oninput='on_change(1)' onblur='on_change(2)' required> / 100
                        </div>
                        <!--OCENA-->
                    </div>
                <!--TOP-->
                ";
                //TOP

                //BOTTOM
                echo"
                <!--BOTTOM-->
                    <div class='bottom'>
                        <!--ODDAJA-->
                        <div class='file_con left'>
                            <div class='title'>
                                Oddaja <sup><span class='date'>(". $new_date .")</span></sup>
                            </div>
                            <div>
                ";

                //render different icons, depending on file extension
                $file_ext = $user_data_row['file_ext'];
                $file_name = $user_data_row["ime"] . $user_data_row["priimek"] . "-" . $oddaja_row['naslov'];

                if($file_ext == "png"){
                    echo"
                            <div>
                                <img src='Pictures/png_file.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }
                else if($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "webp"){
                    echo"
                            <div>
                                <img src='Pictures/img_file.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }
                else if($file_ext == "doc" || $file_ext == "docx"){
                    echo"
                            <div>
                                <img src='Pictures/doc_file.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }
                else if($file_ext == "pdf"){
                    echo"
                            <div>
                                <img src='Pictures/pdf_file.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }
                else if($file_ext == "zip" || $file_ext == "zipx" || $file_ext == "7z" || $file_ext == "rar" || $file_ext == "pak" || $file_ext == "rpm" || $file_ext == "gz"){
                    echo"
                            <div>
                                <img src='Pictures/zip_file.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }
                else{
                    echo"
                            <div>
                                <img src='Pictures/file_default.png' class='file_icon'><a href='Files/$id_oddaja.$file_ext' class='link' download='" .$file_name . "'>" . $file_name . "." . $file_ext . "</a>
                            </div>
                    ";
                }

                echo"
                        <div>
                            <input type='submit' value='Oceni' class='submit_btn'>
                        </div>
                        </div>
                    </div>
                    <!--ODDAJA-->
                ";

                echo"
                    <!--KOMENTAR-->
                    <div class='comment_con right'>
                        <span class='title'>Komentar:</span> <textarea name='comment' maxlength='100'>". $user_data_row['komentar'] ."</textarea>
                    </div>
                    <!--KOMENTAR-->
                </div>
                <!--BOTTOM-->
                ";
            }

            //if not display error message
            else{
                echo"
                <h1>Dostop prepovedan.</h1>
                ";
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
    </form>
</body>

<!--SCRIPT-->
<script>
    on_change(2);
</script>
<!--SCRIPT-->

</html>