<?php
    // echo('<script>alert("fuck")</script>');
    if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        // echo '<script>alert("fuck")</script>';
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
            if($result->enable) {
                $token = md5(uniqid());
                $update_user = array(
                    'login_status' => true,
                    'token' => $token
                ); 
                $user->update($result['_id'], $update_user);

                $_SESSION['user'] = [
                    'user_id' => $result['_id'],
                    'avatar' => $result['avatar'],
                    'username' => $result['username'],
                    'is_admin' => $result['is_admin'],
                    'token' => $token
                ];
                echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
            }
        } 
        else
        {
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
            echo "<script>alert('User not found!! Please check your email and password!!')</script>";
        }
    }
