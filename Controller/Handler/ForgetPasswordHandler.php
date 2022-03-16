<?php
$user = new User();

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['submit_email'])) {
   $getEmail = $_POST['email'];
   $user_email_input = array(
      'email' => $getEmail
   );
   $result = $user->getUser('register', $user_email_input);
   // Lấy email và pass từ db
   $email = $result['email'];
   $pass = md5($result['password']);
   // Tạo đường link để gửi mail và pass vừa lấy về
   $url = "<a href='http:localhost:7000/php2/webchat/index.php?ctrl=UserController&action=view_reset_password&key=".$email."&reset=".$pass."'>Click here to reset your password.</a>";

   $mail = new PHPMailer();

   $mail->isSMTP();                                      // Set mailer to use SMTP
   $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = 'phpwebchat2022@gmail.com';         // SMTP username
   $mail->Password = 'phpwebchat@@';                     // SMTP password
   $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 587;                                    // TCP port to connect to

   $mail->isHTML(true);
   $mail->setFrom($_POST['email'], 'receiver name');
   $mail->addAddress($getEmail);
   $mail->Subject = 'Reset password';
   $mail->Body    = 'http:localhost:7000/php2/webchat/index.php?ctrl=UserController&action=view_reset_password&key='.$email.'&reset='.$pass;

   if ($mail->send()) {
      $status = "success";
      $response = "Email is sent !";
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_forget_password' />";
      // echo '<script>$(".sent-notification").html("<div class="alert alert-success" role="alert">Message sent!</div>");</script>';
   } else {
      $status = "failed";
      $response = "Something is wrong: <br><br>" . $mail->ErrorInfo;
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_forget_password' />";
      // echo '<script>$(".sent-notification").html("<div class="alert alert-danger" role="alert">Message could not be sent. Please try again later.</div>");</script>';
   }

   exit(json_encode(array("status" => $status, "response" => $response)));
}


