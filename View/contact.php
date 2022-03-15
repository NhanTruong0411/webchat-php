<?php
//index.php

$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
   $string = trim($string);
   $string = stripslashes($string);
   $string = htmlspecialchars($string);
   return $string;
}

if (isset($_POST["submit"])) {
   echo '<script>alert("yuityityuityi")</script>';
   // if (empty($_POST["name"])) {
   //    $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
   // } else {
   //    $name = clean_text($_POST["name"]);
   //    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
   //       $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
   //    }
   // }
   // if (empty($_POST["email"])) {
   //    $error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
   // } else {
   //    $email = clean_text($_POST["email"]);
   //    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   //       $error .= '<p><label class="text-danger">Invalid email format</label></p>';
   //    }
   // }
   // if (empty($_POST["subject"])) {
   //    $error .= '<p><label class="text-danger">Subject is required</label></p>';
   // } else {
   //    $subject = clean_text($_POST["subject"]);
   // }
   // if (empty($_POST["message"])) {
   //    $error .= '<p><label class="text-danger">Message is required</label></p>';
   // } else {
   //    $message = clean_text($_POST["message"]);
   // }
   // if ($error == '') {
   //    var_dump($name);
   //    var_dump($email);
   //    var_dump($subject);
   //    var_dump($message);
      // De send duoc email thì phải chỉnh Cho Phép Ứng Dụng Kém An Toàn
      // nếu không email sẽ chặn việc send mail đi

      // Một số ứng dụng và thiết bị sử dụng công nghệ đăng nhập kém an toàn, khiến tài khoản của bạn dễ bị tấn công.
      // Chúng tôi khuyên bạn tắt quyền truy cập của các ứng dụng đó.
      // Bạn vẫn có thể cấp quyền truy cập để dùng các ứng dụng đó, nhưng rủi ro có thể xảy ra.
      // Google sẽ tự động TẮT tùy chọn cài đặt này nếu bạn không sử dụng.
      // https://support.google.com/accounts?p=less-secure-apps&hl=vi
      //
      // require '../Model/mailer/class.phpmailer.php';
      // $mail = new PHPMailer;
      // $mail->IsSMTP();                                            //Sets Mailer to send message using SMTP
      // $mail->Host = 'smtp.gmail.com';                             //Sets the SMTP hosts of your Email hosting, this for Godaddy
      // $mail->Port = 587;                                          //Sets the default SMTP server port
      // $mail->SMTPAuth = true;                                     //Sets SMTP authentication. Utilizes the Username and Password variables
      // $mail->Username = 'phpwebchat2022@gmail.com';               //Sets SMTP username
      // $mail->Password = 'phpwebchat@@';                           //Sets SMTP password
      // $mail->SMTPSecure = 'tls';                                  //Sets connection prefix. Options are "", "ssl" or "tls"
      // $mail->From = 'phpwebchat2022@gmail.com';                   //Sets the From email address for the message
      // $mail->FromName = 'User';                                   //Sets the From name of the message
      // $mail->AddAddress($_POST["email"], $_POST["name"]);         //Adds a "To" address
      // //$mail->AddCC($_POST["email"], $_POST["name"]);			   //Adds a "Cc" address
      // $mail->WordWrap = 50;                                       //Sets word wrapping on the body of the message to a given number of characters
      // $mail->IsHTML(true);                                        //Sets message type to HTML				
      // $mail->Subject = $_POST["subject"];                         //Sets the Subject of the message
      // $mail->Body = $_POST["message"];                            //An HTML or plain text message body
      // if ($mail->Send())                                          //Send an Email. Return true on success or false on error
      // {
      //    echo '<script>alert("Message has been sent.")</script>';
      // } else {
      //    echo '<script>alert("Something went wrong, please try again !")</script>';
      // }
      // $name = '';
      // $email = '';
      // $subject = '';
      // $message = '';
   // }
}

$user = $_SESSION['user'];

$_user = new User();

?>
<!-- heading -->
<div class="container text-center profile_heading" style="padding: 3em 0 0 0;">
   <div class="row justify-content-center">
      <div class="col-md-6 text-center mb-3">
         <h2 class="heading-section" style="font-size: 125px !important;">Contact Us</h2>
      </div>
   </div>
</div>

<div class="container text-center profile_main">
   <div class="row justify-content-center">
      <div class="mt-3 mb-3 text-center w-75">
         <form method="POST">

            <input type="hidden" class="form-control" id="fromEmail" value="phpwebchat2022@gmail.com">

            <div class="form-group text-left ">
               <label for="name" class="text-dark">Your Name</label>
               <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group text-left ">
               <label for="email" class="text-dark">Your Email</label>
               <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group text-left ">
               <label for="subject" class="text-dark">Subject</label>
               <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $subject; ?>" required>
            </div>
            <div class="form-group text-left ">
               <label for="message" class="text-dark">Message</label>
               <textarea class="form-control" id="message" rows="15" name="message" value="<?php echo $message; ?>" required></textarea>
            </div>
            <div class="row justify-content-center pb-5">
               <button type="submit" class="btn btn-lg btn-info text-lg-center">Send</button>
               <a type="reset" href="index.php?ctrl=UserController&action=view_profile" class="btn btn-lg btn-danger text-lg-center mx-3 text-white">Reset</a>
               <?php
               if ($user['is_admin'] == "true") {
                  echo '<a href="index.php?ctrl=AdminController&action=view_dashboard" class="btn btn-lg btn-success text-lg-center text-white mr-3">Back to Dashboard</a>';
               }
               ?>
               <a href="index.php?ctrl=ChatController&action=view_chatbox" class="btn btn-lg btn-warning text-lg-center text-dark">Back to chat</a>
            </div>
         </form>
      </div>
   </div>

</div>