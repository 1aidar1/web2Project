<?php

if(!isset($_SERVER['HTTPS'])){
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $url);
    exit;
}

require('model.php');
require('model2.php');

$isSigned = false;
$display_type = 'no-signin';
$error_msg_handle_signin = '';
$error_msg_password_signin = '';
$error_msg_UIN_register = '';
$error_msg_handle_register = '';
$error_msg_tel_register = '';
$error_msg_password_register = '';

$UIN = '';
$handle = '';
$password = '';
$tel = '';
$id = -1;

$page = NULL;
$command = NULL;

if (isset($_SESSION['handle'])){
    if(check_validity($_SESSION['handle'],$_SESSION['password'] )) {
        $handle = $_SESSION['handle'];
        $password = $_SESSION['password'];
        $isSigned = true;
        $display_type = 'no-sign-in';
        $id = get_user_id($handle);
        $ans = array(
            "isSigned" => $isSigned,
            "display" => $display_type
        );
        echo json_encode($ans);
        exit();
    } 
}//TODO: signin onload page



if (empty($_POST['page'])) {
    include('MainPage.php');
} else {
    $page = $_POST['page'];
    if ($page == 'MainPage') {
        if(isset($_POST['command'])){
            $command = $_POST['command'];
        }
        switch ($command) {
            case 'SignIn':
                if(isset($_POST['handle'])){
                    $handle = $_POST['handle'];
                }
                if(isset($_POST['password'])){
                    $password = $_POST['password'];
                }
                if (check_validity($handle, $password)) {
                    
                    $_SESSION['handle'] = $handle;
                    $_SESSION['password'] = $password;
                    $isSigned = true;
                    $display_type = 'no-sign-in';
                    $id = get_user_id($handle);
                } else {
                    $isSigned = false;
                    $display_type = 'sign-in';
                    $error_msg_handle_signin = 'Wrong handle, or';
                    $error_msg_password_signin = 'Wrong password';
                }
                $ans = array(
                    "isSigned" => $isSigned,
                    "display" => $display_type,
                    "error_msg_handle_signin" => $error_msg_handle_signin,
                    "error_msg_password_signin" => $error_msg_password_signin,
                    "error_msg_UIN_register" => $error_msg_UIN_register,
                    "error_msg_handle_register" => $error_msg_handle_register,
                    "error_msg_tel_register" => $error_msg_tel_register,
                    "error_msg_password_register" => $error_msg_password_register
                );
                echo json_encode($ans);
                break;
            case 'Register':
                $UIN = $_POST['UIN'];
                $handle = $_POST['handle'];
                $password = $_POST['password'];
                $tel = $_POST['tel'];
                if (join_a_user($UIN, $handle, $password, $tel)) {
                    $display_type = 'no-sign-in';
                } else {
                    $display_type = 'register';
                    $error_msg_UIN_register = 'Error';
                }
                $ans = array(
                    "isSigned" => $isSigned,
                    "display" => $display_type,
                    "error_msg_handle_signin" => $error_msg_handle_signin,
                    "error_msg_password_signin" => $error_msg_password_signin,
                    "error_msg_UIN_register" => $error_msg_UIN_register,
                    "error_msg_handle_register" => $error_msg_handle_register,
                    "error_msg_tel_register" => $error_msg_tel_register,
                    "error_msg_password_register" => $error_msg_password_register
                );
                echo json_encode($ans);
                break;
        }
    }
    else if($page == 'UserPage'){
        if(isset($_POST['command'])){
            $command = $_POST['command'];
        }
        switch($command){
            case 'ChangeUIN':
                if(isset($_POST['new_UIN'])){
                    $UIN = $_POST['new_UIN'];
                }
                echo change_UIN($UIN,$id);
                break;
            case 'ChangeHandle':
                if(isset($_POST['new_handle'])){
                    $handle = $_POST['new_handle'];
                }
                echo change_handle($handle,$id);
                break;
            case 'ChangePassword':
                if(isset($_POST['new_password'])){
                    $password = $_POST['new_password'];
                }
                echo change_UIN($password,$id);
                break;
            case 'ChangeTel':
                if(isset($_POST['new_tel'])){
                    $tel= $_POST['new_tel'];
                }
                echo change_tel($tel,$id);
                break;
        }
    }
}
