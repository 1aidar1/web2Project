<?php

if(!isset($_SERVER['HTTPS'])){
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $url);
    exit;
}

require('model.php');

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

if (empty($_POST['page'])) {
    include('MainPage.php');
} else {
    $page = $_POST['page'];
    if ($page == 'MainPage') {
        $command = $_POST['command'];
        switch ($command) {
            case 'SignIn':
                if(isset($_POST['handle'])){
                    $handle = $_POST['handle'];
                }
                if(isset($_POST['password'])){
                    $password = $_POST['password'];
                }
                if (check_validity($handle, $password)) {
                    $isSigned = true;
                    $display_type = 'no-sign-in';
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

    }
}
