<?php
include("config.php");
session_start();

if (!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['user_type'], $_SESSION['pass'], $_GET['type'], $_GET['id'])) {
    header('location: login.php');
}

//if the user is logged in, allow access
else {
    $type = $_GET['type'];
    $get_id = $_GET['id'];
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

/*--------------------------------*//*DELETION CODE*//*--------------------------------*/

//delete submission
if($type == 1){
    //submission data
    $del_exists_query = "SELECT * FROM `oddaja` WHERE `id_oddaja` = '$get_id'";
    $del_exists_result = mysqli_query($db, $del_exists_query);
    $del_exists_count = mysqli_num_rows($del_exists_result);

    //check if submission exists
    if($del_exists_count != 0){
        $del_row = mysqli_fetch_assoc($del_exists_result);
        $id_gradivo = $del_row['id_gradiva'];

        //if user is the author of the upload or the admin, allow DELETE statement
        if($del_row["id_user"] == $id || $user_type == 0){
            //delete submission
            $delete_query = "DELETE FROM `oddaja` WHERE `id_oddaja` = '$get_id'";
            $delete_result = mysqli_query($db, $delete_query);

            //redirect back to material.php
            header("location: ../material.php?gradivo='$id_gradiva'");
        }
        else{
            //redirect back to material.php
            header("location: ../material.php?gradivo='$id_gradiva'");
        }   
    }    
    else{
        //redirect home
        header("location: ../home.php");
    }
}

//delete user
if($type == 2){
    //user data
    $user_exists_query = "SELECT * FROM `user` WHERE `id_user` = '$get_id';";
    $user_exists_result = mysqli_query($db, $user_exists_query);
    $user_exists_count = mysqli_num_rows($user_exists_result);

    //check if user exists
    if($user_exists_count != 0){
        //check if user is admin
        if($user_type == 0){
            $user_row = mysqli_fetch_assoc($user_exists_result);
            //check that the targeted user is not an admin or the user itself
            if($user_row['user_type'] != 0 || $get_id != $id){
                $oddaja_del_query = "DELETE FROM `oddaja` WHERE `id_user` = '$get_id'";
                $oddaja_del_result = mysqli_query($db, $oddaja_del_query);

                $ucilnica_del_query = "DELETE FROM `ucilnica` WHERE `id_user` = '$get_id'";
                $ucilnica_del_result = mysqli_query($db, $ucilnica_del_query);

                $user_del_query = "DELETE FROM `user` WHERE `id_user` = '$get_id'";
                $user_del_result = mysqli_query($db, $user_del_query);

                //redirect back to users.php when done
                header("location: ../users.php");
            }
            else{
                header("location: ../users.php");
            }
        }
        else{
            header("location: ../vp.php");
        }


    }
    else{
        header("location: ../vp.php");
    }
}

?>