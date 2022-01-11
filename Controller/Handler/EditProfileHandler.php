<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

   // connect class to use methods
   $user = new User();

   //
   $result = $user->getUser('edit_pass', $_SESSION['user']);
   // var_dump($result);

   // $result = iterator_to_array($result, false);

   // variables
   if (!empty($_POST['username'])) {
      $username = $_POST['username'];
      $result['username'] = $_POST['username'];
   }
   if (!empty($_POST['new_pass'])) {
      $new_pass = $_POST['new_pass'];
   }
   if (!empty($_FILES["avatar_name"]["name"])) {
      $target_dir = "images/";
      $target_file = $target_dir . basename($_FILES["avatar_name"]["name"]);
      $uploadOk = 1;
      $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   }
   // echo gettype($result);
   $user->save($result);








   // if (empty($target_file) && empty($old_pass) && empty($new_pass) && empty($c_new_pass) && $username === $_SESSION['user']['username']) {

      // echo '<script>alert("Please enter the information that you want to change !")</script>';
      // echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
   // }

   // Case missing avatar, only change input field
   // if (empty($target_file)) {
      // echo "hello";
      // check only username inside
      // if (empty($old_pass) && empty($new_pass) && empty($c_new_pass)) {

         // $user_edit_input = array(
         //    'username' => $username
         // );
         // $user->update($_SESSION['user']['user_id'], $user_edit_input);
         // echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
      // }

      // // Check missing some password fields (include 3 fields)
      // if ($old_pass && empty($new_pass) && empty($c_new_pass) || $old_pass && $new_pass && empty($c_new_pass)) {
      //    echo '<script>alert("Please fill all fields !")</script>';
      //    echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
      // }

      // // If all fielsd have been fill, get the old password inside the database to compare wirh the new password
      // if ($old_pass && $new_pass && $c_new_pass) {
      //    $user_update = array(
      //       'user_id' => $_SESSION['user']['user_id']
      //    );
      //    $result = $user->getUser('edit_pass', $user_update);

      //    // Check if old password does not correct
      //    if ($result['password'] !== $old_pass_hashed) {
      //       echo '<script>alert("Old password does not match !")</script>';
      //       echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";

      //       // check if new password and confirm new password does not correct each other
      //    } else if ($new_pass_hashed !== $c_new_pass_hashed) {
      //       echo '<script>alert("Confirm new password does not correct !")</script>';
      //       echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";

      //       // all conditions pass : update new passsword into database
      //    } else {
      //       $user_password_change = array('password' => $new_pass_hashed);
      //       $user->update($_SESSION['user']['user_id'], $user_password_change);
      //       echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=ChatController&action=view_chatbox' />";
      //    }
      // }
   // }
   // Case having avatar
   // else {
   //    // Case only avatar makes a change, everthing else the same
   //    if ($target_file && empty($old_pass) && empty($new_pass) && empty($c_new_pass) && $username === $_SESSION['user']['username']) {
   //       include 'EditProfileAvatar.php';
   //       echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
   //    }
   // }
}
