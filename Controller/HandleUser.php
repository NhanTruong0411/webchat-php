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
            $user_login_input = array(
                'email' => $_POST['email'],
                'password' => $_POST['password']
            );
            var_dump($user_login_input);
            break;
        case 'view_register':
            include 'View/register.php';
            break;
        case 'handle_register':
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $email = strtolower($_POST['email']);
                $username = remove_sign($_POST['username']);
                $hashed_password = md5($_POST['password']);
                //define an object
                $user_register_input = array(
                    'email' =>  $email,
                    'username' => $username,
                    'password' => $hashed_password
                );
            }
            $user = new User();
            $user->register($user_register_input);
            break;
        case 'logout':

            break;
    }

?>