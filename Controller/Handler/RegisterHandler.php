<?php

use PHPMailer\PHPMailer\PHPMailer;

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
            $inserted_userid = $user->register($user_register_input);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'phpwebchat2022@gmail.com';
            $mail->Password = 'phpwebchat@@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPSecure = 'tls';    
            $mail->Port = 587;

            $mail->setFrom('phpwebchat2022@gmail.com', 'Nhan Truong');
            $mail->addAddress($user_register_input['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Registration Verify code for Webchat!';

            $mail->Body = '
                <p>Thank you for registering</p>
                <p>This is a verification email. Please click in the link below to verify your account!</p>
                <p><a href="http://localhost:7000/Webchat2/index.php?ctrl=UserController&action=verify&code='.$user->getUserVerificationCode($inserted_userid).'">Click to verify</a></p>
                <p>Thank you for registering</p>
            ';

            $mail->send();

            $success_message = 'Registration Completed!';

            echo '<script>alert("Verify email sent to '.$user_register_input['email'].'. Please verify your email before continue!")</script>';

            // echo $user->getUserVerificationCode($inserted_userid);

            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
        } 
        else 
        {
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_register' />";
            echo "<script>alert('User already exist!!')</script>";
        }
    }

?>