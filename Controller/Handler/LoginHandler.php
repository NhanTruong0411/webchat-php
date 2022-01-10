<?php

    if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $email = strtolower($_POST['email']);
        $hashed_password = md5($_POST['password']);

        //define an object
        $user_login_input = array(
            'email' =>  $email,
            'password' => $hashed_password
        );

        $user = new User();
        $result = $user->getUser('login', $user_login_input);

        if(!empty($result)) 
        {
            $update_user = array(
                'login_status' => true,
            );
            $user->update($result['_id'], $update_user);

            $current_user = array(
                'user_id' => $result['_id'],
                'avatar' => $result['avatar'],
                'username' => $result['username']
            );
            $_SESSION['user'] = $current_user;
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
        } 
        else 
        {
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
            echo "<script>alert('User not found!! \n Please check your email and password!!')</script>";
        }
    }

?>