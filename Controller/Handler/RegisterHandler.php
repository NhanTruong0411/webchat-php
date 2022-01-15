<?php

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

        $result = $user->getUser('register', $user_register_input);
        
        if(empty($result)) 
        {
            $user->register($user_register_input);
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
        } 
        else 
        {
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_register' />";
            echo "<script>alert('User already exist!!')</script>";
        }
    }

?>