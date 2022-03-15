<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

   $user_session = $_SESSION['user'];

   // get all the user record
   $result = $user->getUserById($user_session['user_id']);

   $update = [];

   if (!empty($_POST['username'])) {
      $update['username'] = $_POST['username'];
      $user_session['username'] = $_POST['username'];
   }

   if (!empty($_POST['new_pass'])) {
      $update['password'] = md5($_POST['new_pass']);
   }

   if (!empty($_FILES["avatar_name"]["name"])) {

      #region Prepare file name
      $target_dir = "images/";
      $file = $_FILES["avatar_name"]["name"];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $temp_name = $_FILES['avatar_name']['tmp_name'];
      $path_filename_ext = $target_dir . $user_session['user_id'] . "_" . $filename . "." . $ext;
      $update['avatar'] = $path_filename_ext;
      $old_user_avatar = $user_session['avatar'];
      $user_session['avatar'] = $path_filename_ext;
      #endregion

      #region Check exist then remove old file and save new one
      if (file_exists($path_filename_ext)) {
         echo "File already exists!";
      } else {
         unlink(realpath(dirname(__DIR__, 2)) . "/" . $old_user_avatar);
         move_uploaded_file($temp_name, $path_filename_ext);
      }
      #endregion
   }

   $user->update($user_session['user_id'], $update);
   if ($user_session['is_admin']) {
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=AdminController&action=view_dashboard' />";
   } else {
      echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=logout' />";
   }
}
