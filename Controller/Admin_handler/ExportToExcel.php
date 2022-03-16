<?php

$user = new User();
$all_users = $user->getAllUser();
$output = '';

if(isset($_POST["export_excel"])) {
   $result = $user->getAllUser();
   $output .= '
   <table class="table" border="1">
      <tr>
         <th>#</th>
         <th>User name</th>
         <th>User email</th>
      </tr>
   ';

   for ($i = 0; $i < count($all_users); $i++) {
      $set = $all_users[$i];
      $output .= '
      <tr>
         <td>'.$i.'</td>
         <td>'.$set['username'].'</td>
         <td>'.$set['email'].'</td>
         </tr>
      ';
   }

   $output .= '</table>';

   header('Content-Type: application/xls');
   header('Content-Disposition: attachment; filename=user_list.xls');

   echo $output;

}

?>