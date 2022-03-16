<?php 

    $action = 'view_login';

    if(isset($_GET['action']))
        $action = $_GET['action'];

    function remove_sign($str) {
        //remove special character
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }

    $user = new User();

    switch($action) {
        case 'view_login':
            include 'View/login.php';
            break;
        case 'handle_login':
            include 'Controller/Handler/LoginHandler.php';
            break;
        case 'view_register':
            include 'View/register.php';
            break;
        case 'handle_register':
            include 'Controller/Handler/RegisterHandler.php';
            break;
        case 'logout':
            include 'Controller/Handler/LogoutHandle.php';
            break;
        case 'view_profile':
            include 'View/profile.php';
            break;
        case 'handle_edit_profile':
            include 'Controller/Handler/EditProfileHandler.php';
            break;
        case 'view_contact':
            include 'View/contact.php';
            break;
        case 'handle_contact':
            include 'Controller/Handler/ContactHandler.php';
            break;
        case 'view_forget_password':
            include 'View/forgetpassword.php';
            break;
        case 'handle_forget_password':
            include 'Controller/Handler/ForgetPasswordHandler.php';
            break;
        case 'view_reset_password':
            include 'View/resetpassword.php';
            break;
        case 'handle_reset_password':
            include 'Controller/Handler/ResetPasswordHandler.php';
            break;
    }

?>