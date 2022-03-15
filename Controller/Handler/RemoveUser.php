<?php
   $user = new User();
   $user->removeUser();
   echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=AdminController&action=view_dashboard' />";
?>