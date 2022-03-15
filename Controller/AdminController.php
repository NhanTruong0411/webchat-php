<?php 

   $action = 'view_dashboard';

   if(isset($_GET['action']))
      $action = $_GET['action'];

   function remove_sign($str) {
      //remove special character
      return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
   }

   // $user = new User();

   switch($action) {
      case 'view_dashboard':
         include 'View/admin/dashboard.php';
         break;
      case 'remove_user':
         include 'Controller/Handler/RemoveUser.php';
         break;
   }

?>