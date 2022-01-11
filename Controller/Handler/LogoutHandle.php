<?php
   $user = new User();
   $user_update = array('login_status' => false);
   $user->update($_SESSION['user']['user_id'], $user_update);
   session_destroy();
   echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";
?>
