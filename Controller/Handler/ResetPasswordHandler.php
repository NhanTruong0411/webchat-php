<?php

if(isset($_POST['submit_reset'])) {
   $email = $_POST['key'];
   $pass = md5($_POST['pass']);
   $c_pass = md5($_POST['c-pass']);

   if($pass !== $c_pass) {
      echo '<script>alert("Password and confirm password not match!")</script>';
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_reset_password' />";
      
   } else {
      $user = new User();
      $result = $user->getUser('register', ['email' => $email]);

      $update = [];

      $update['password'] = $pass;

      $user->resetPassword($email, $update);

      echo '<script>alert("Password has been reset!")</script>';
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";

      $pass = '';
      $c_pass = '';
   }
}





?>