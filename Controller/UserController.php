<?php 

    $action = 'view_login';

    if(isset($_GET['action']))
        $action = $_GET['action'];

    function remove_sign($str) {
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

            break;
    }

?>