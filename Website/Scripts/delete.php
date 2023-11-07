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
        //$id_gradiva = $del_row['id_gradiva'];

        //if user is the author of the upload or the admin, allow DELETE statement
        if($del_row["id_user"] == $id || $user_type == 0){
            //delete submission
            $delete_query = "DELETE FROM `oddaja` WHERE `id_oddaja` = '$get_id'";
            $delete_result = mysqli_query($db, $delete_query);

            //redirect back to material.php
            header("location: ../material.php?gradivo='". $del_row["id_gradiva"] ."'");
        }
        else{
            //redirect back to material.php
            header("location: ../material.php?gradivo='". $del_row["id_gradiva"] ."'");
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

//delete subject
if($type == 3){
    //check if user is an admin or student
    if($user_type == 0 || $user_type == 2){
        //check that class exists
        $class_exists_query = "SELECT * FROM `predmeti`
        WHERE `id_predmet` = '$get_id'";
        $class_exists_result = mysqli_query($db, $class_exists_query);
        $class_exists_count = mysqli_num_rows($class_exists_result);

        //class exists
        if($class_exists_count > 0){
            //if the user is a student, drop subject
            if($user_type == 2){
                //check that the student is signed into the subject
                $user_sign_query = "SELECT * FROM `ucilnica`
                WHERE `id_predmet` = '$get_id' 
                AND `id_user` = '$id';
                ";
                $user_sign_result = mysqli_query($db, $user_sign_query);
                $user_sign_count = mysqli_num_rows($user_sign_result);

                //student is signed up
                if($user_sign_count > 0){
                    //delete from oddaja
                    $sub_del_query = "DELETE FROM `oddaja` WHERE `id_user` = '$id'";
                    $sub_del_result = mysqli_query($db, $sub_del_query);

                    //delete from ucilnica
                    $sign_del_query = "DELETE FROM `ucilnica` 
                    WHERE `id_user` = '$id' 
                    AND `id_predmet` = '$get_id'";
                    $sign_del_result = mysqli_query($db, $sign_del_query); 

                    
                }
            }

            //if the user is an admin, delete the subject alltogether
            else if($user_type == 0){
                //get all modules
                $module_query = "SELECT * FROM `model` WHERE `id_predmet` = '$get_id'";
                $module_result = mysqli_query($db, $module_query);
                $module_count = mysqli_num_rows($module_result);

                //if the subject has any modules continue through to oddaja table
                if($module_count > 0){
                    //loop through all modules
                    while($mod_row = mysqli_fetch_assoc($module_result)){
                        $gradiva_query = "SELECT * FROM `gradiva` 
                        WHERE `id_modula` = '". $mod_row['id_modula'] ."'";
                        $gradiva_result = mysqli_query($db, $gradiva_query);
                        $gradiva_count = mysqli_num_rows($gradiva_result);

                        //if there are materials under a module loop through them
                        if($gradiva_count > 0){
                            //loop through materials
                            while($gradiva_row = mysqli_fetch_assoc($gradiva_result)){
                                //delete submissions for each material
                                $oddaja_query = "DELETE FROM `oddaja` 
                                WHERE `id_gradiva` = '" . $gradiva_row['id_gradiva'] . "'";
                                $oddaja_result = mysqli_query($db, $oddaja_query);
                            }

                            //delete materials for each module
                            $gradiva_del_query = "DELETE FROM `gradiva` 
                            WHERE `id_modula` = '" . $mod_row['id_modula'] . "'";
                            $gradiva_del_result = mysqli_query($db, $gradiva_del_query);
                        }
                    }

                    //delete modules of the subject
                    $mod_del_query = "DELETE FROM `model` WHERE `id_predmet` = '$get_id'";
                    $mod_del_result = mysqli_query($db, $mod_del_query);
                }

                //ucilnica table
                $ucilnica_query = "SELECT * FROM `ucilnica` WHERE `id_predmet` = '$get_id'";
                $ucilnica_result = mysqli_query($db, $ucilnica_query);
                $ucilnica_count = mysqli_num_rows($ucilnica_result);

                if($ucilnica_count > 0){
                    $sign_del_query = "DELETE FROM `ucilnica` 
                    WHERE `id_predmet` = '$get_id'";
                    $sign_del_result = mysqli_query($db, $sign_del_query); 
                }

                //finally DELETE subject - predmeti table
                $predmet_del_query = "DELETE FROM `predmeti` WHERE `id_predmet` = '$get_id';";
                $predmet_del_result = mysqli_query($db, $predmet_del_query);
            }
        }   
        
    }
    header("location: ../class.php");
}

//delete module
if($type == 4){
    //check that module exists
    $mod_exists_query = "SELECT `m`.* 
    FROM `model` `m` JOIN `predmeti` `p`
        ON `m`.`id_predmet` = `p`.`id_predmet` 
    WHERE `id_modula` = '$get_id'; 
    ";
    $mod_exists_result = mysqli_query($db, $mod_exists_query);
    $mod_exists_count = mysqli_num_rows($mod_exists_result);

    //module exists
    if($mod_exists_count > 0){
        $mod_exists_row = mysqli_fetch_assoc($mod_exists_result);

        //check that user is an admin or teacher
        if($user_type == 1 || $user_type == 0){
            //if user is a teacher, check that he is teaching the class
            if($user_type == 1){
                $teacher_query = "SELECT * FROM `ucilnica`
                WHERE `id_user` = '$id'
                AND `id_predmet` = '". $mod_exists_row['id_predmet'] ."';
                ";
                $teacher_result = mysqli_query($db, $teacher_query);
                $teacher_count = mysqli_num_rows($teacher_result);
                
                //if not, redirect to class.php
                if($teacher_result <= 0){
                    header("location: ../class.php");
                }
            }

            //check if module has any children rows in gradiva and oddaja table
            $gradiva_exists_query = "SELECT * FROM `gradiva`
            WHERE `id_modula` = '". $mod_exists_row['id_modula'] ."'
            ";
            $gradiva_exists_result = mysqli_query($db, $gradiva_exists_query);
            $gradiva_exists_count = mysqli_num_rows($gradiva_exists_result);

            //if there are rows in gradiva, loop through each one and delete associated submissions in oddaja
            if($gradiva_exists_count > 0){
                while($gradiva_exists_row = mysqli_fetch_assoc($gradiva_exists_result)){
                    $oddaja_del_query = "DELETE FROM `oddaja` 
                    WHERE `id_gradiva` = '" . $gradiva_exists_row['id_gradiva'] . "'";
                    $oddaja_del_result = mysqli_query($db, $oddaja_del_query);
                }

                //delete children materials
                $gradiva_del_query = "DELETE FROM `gradiva` WHERE `id_modula` = '". $mod_exists_row['id_modula'] ."'";
                $gradiva_del_result = mysqli_query($db, $gradiva_del_query);
            }

            //delete module
            $module_del_query = "DELETE FROM `model` WHERE `id_modula` = '$get_id'";
            $module_del_result = mysqli_query($db, $module_del_query);

            header("location: ../course.php?id=". $mod_exists_row['id_predmet']);
        }

        header("location: ../course.php?id=". $mod_exists_row['id_predmet']);
    }

    header("location: ../class.php");
}


//delete material
if($type == 5){
    //check if user is an admin or teacher
    if($user_type == 0 || $user_type == 1){
        $gradiva_exists_query = "SELECT `g`.*, `p`.`id_predmet` 
        FROM `gradiva` `g` JOIN `model` `m`
            ON `g`.`id_modula` = `m`.`id_modula` JOIN `p`.`id_predmet`
            ON `m`.`id_predmet` = `p`.`id_predmet`  
        WHERE `id_gradiva` = '$get_id'";
        $gradiva_exists_result = mysqli_query($db, $gradiva_exists_query);
        $gradiva_exists_count = mysqli_num_rows($gradiva_exists_result);

        //material exists
        if($gradiva_exists_result > 0){
            $g_temp_row = mysqli_fetch_assoc($gradiva_exists_result);
            //if the user is a teacher, check that he is assigned to the class
            if($user_type == 1){
                $teacher_g_query = "SELECT FROM `ucilnica`
                WHERE `id_user` = '$id' 
                AND `id_predmet` = '" . $g_temp_row['id_predmet'] . "'";
                $teacher_g_result = mysqli_query($db, $teacher_g_query);
                $teacher_g_count = mysqli_num_rows($teacher_g_result);

                if($teacher_g_count <= 0){
                    header("location: ../class.php");
                }
            }
            

            //delete all related submissions, should there be any
            /*while($gradiva_exists_row = mysqli_fetch_assoc($gradiva_exists_result)){*/
            $oddaja_del_query = "DELETE FROM `oddaja` 
            WHERE `id_gradiva` = '" . $g_temp_row['id_gradiva'] . "'";
            $oddaja_del_result = mysqli_query($db, $oddaja_del_query);
            //}

            //delete class material
            $gradiva_del_query = "DELETE FROM `gradiva` WHERE `id_gradiva` = '$get_id'";
            $gradiva_del_result = mysqli_query($db, $gradiva_del_query);

            header("location: course.php?id=" . $g_temp_row['id_predmet']);
        }
    }

    header("location: ../class.php");
}
?>