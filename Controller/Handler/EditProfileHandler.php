<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // variables
   $user_session = $_SESSION['user'];
   $update = [];

   // create new class to use it methods
   $user = new User();

   // get all the user record
   $result = $user->getUserById($user_session['user_id']);

   if (!empty($_POST['username'])) {
      $update['username'] = $_POST['username'];
      // $user_session['username'] = $_POST['username'];
   }

   if (!empty($_POST['new_pass'])) {
      $update['password'] = md5($_POST['new_pass']);
   }

   if (!empty($_FILES["avatar_name"]["name"])) {
      $target_dir = "images/";
      $target_file = $target_dir . basename($_FILES["avatar_name"]["name"]);
      $uploadOk = 1;
      $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $update['avatar'] = $target_file;
      require_once 'EditProfileAvatar.php';
      // $user_session['avatar'] = $target_file;
   }
   
   $user->update($user_session['user_id'], $update);
   echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
}