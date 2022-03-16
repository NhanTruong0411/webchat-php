<?php

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (isset($_POST['name']) && isset($_POST['email'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $message = $_POST['message'];
      $subject = $_POST['subject'];
   }

   $mail = new PHPMailer();

   $mail->isSMTP();                                      // Set mailer to use SMTP
   $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = 'phpwebchat2022@gmail.com';         // SMTP username
   $mail->Password = 'phpwebchat@@';                     // SMTP password
   $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 587;                                    // TCP port to connect to

   $mail->isHTML(true);
   $mail->setFrom($_POST['email'], $_POST['name']);
   $mail->addAddress('phpwebchat2022@gmail.com');
   $mail->Subject = $subject;
   $mail->Body    = $message;

   if ($mail->send()) {
      $status = "success";
      $response = "Email is sent !";
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_contact' />";
      echo '<script>$(".sent-notification").html("<div class="alert alert-success" role="alert">Message sent!</div>");</script>';
   } else {
      $status = "failed";
      $response = "Something is wrong: <br><br>" . $mail->ErrorInfo;
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_contact' />";
      echo '<script>$(".sent-notification").html("<div class="alert alert-danger" role="alert">Message could not be sent. Please try again later.</div>");</script>';
   }

   exit(json_encode(array("status" => $status, "response" => $response)));
}
