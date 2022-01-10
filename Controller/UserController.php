<?php 

    $action = 'view_login';

    if(isset($_GET['action']))
        $action = $_GET['action'];

    function remove_sign($str) {
        //remove special character
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }

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
            $user = new User();
            $user_update = array('login_status' => false);
            $user->update($_SESSION['user']['user_id'], $user_update);
            session_destroy();
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
            break;
    }

?>