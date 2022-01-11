<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // variables
   $target_dir = "images/".$_SESSION['user_id']."/";
   $target_file = $target_dir . basename($_FILES["avatar_name"]["name"]);
   $uploadOk = 1;
   $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   $username = $_POST['username'];
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $c_new_pass = $_POST['c_new_pass'];
   $old_pass_hashed = md5($old_pass);
   $new_pass_hashed = md5($new_pass);
   $c_new_pass_hashed = md5($c_new_pass);
   // connect class to use methods
   $user = new User();

   if (empty($target_file) && empty($old_pass) && empty($new_pass) && empty($c_new_pass) && $username === $_SESSION['user']['username']) {
      echo '<script>alert("Please enter the information that you want to change !")</script>';
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
   }

   // Case missing avatar, only change input field
   if (empty($target_file)) {
      // check only username inside
      if (empty($old_pass) && empty($new_pass) && empty($c_new_pass)) {
         $user_edit_input = array(
            'username' => $username
         );
         $user->update($_SESSION['user']['user_id'], $user_edit_input);
         echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
      }

      // Check missing some password fields (include 3 fields)
      if ($old_pass && empty($new_pass) && empty($c_new_pass) || $old_pass && $new_pass && empty($c_new_pass)) {
         echo '<script>alert("Please fill all fields !")</script>';
         echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
      }

      // If all fielsd have been fill, get the old password inside the database to compare wirh the new password
      if ($old_pass && $new_pass && $c_new_pass) {
         $result = $user->getUser('edit_pass', $_SESSION['user']);

         // Check if old password does not correct
         if ($result['password'] !== $old_pass_hashed) {
            echo '<script>alert("Old password does not match !")</script>';
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";

            // check if new password and confirm new password does not correct each other
         } else if ($new_pass_hashed !== $c_new_pass_hashed) {
            echo '<script>alert("Confirm new password does not correct !")</script>';
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";

            // all conditions pass : update new passsword into database
         } else {
            $user_password_change = array('password' => $new_pass_hashed);
            $user->update($_SESSION['user']['user_id'], $user_password_change);
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
         }
      }
   }
   // Case having avatar
   else {
      // Case only avatar makes a change, everthing else the same
      if ($target_file && empty($old_pass) && empty($new_pass) && empty($c_new_pass) && $username === $_SESSION['user']['username']) {
         include 'EditProfileAvatar.php';
         echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
      }
   }





}
