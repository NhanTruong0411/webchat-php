<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

   $user_session = $_SESSION['user'];

   $user = new User();

   $result = $user->getUser('edit_pass', $_SESSION['user']);

   $update = [];

   if (!empty($_POST['username'])) {
      $update['username'] = $_POST['username'];
      $user_session['username'] = $_POST['username'];
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
      $user_session['avatar'] = $target_file;
   }

   $user->update($user_session['user_id'], $update);
   echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_profile' />";
}
