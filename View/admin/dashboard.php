<?php

$user = $_SESSION['user'];

$users = new User();
$all_users = $users->getAllUser();

$i = 0;

?>
<div class="row">
   <div class="col-md-2 col-sm-3 p-0 text-center">
      <div class="card d-flex flex-column" style="height: 100vh !important; background-color: #F9AA33 !important;">
         <img src="<?php echo $user['avatar'] ?>" alt="" width="100" class="img-fluid rounded-circle img-thumbnail mx-auto my-3" />
         <a href="index.php?ctrl=AdminController&action=view_dashboard" class="mt-2 mb-2 text-white">User list</a>
         <a href="index.php?ctrl=UserController&action=view_profile" class="mt-2 mb-2 text-white">Edit admin profile</a>
         <a href="index.php?ctrl=ChatController&action=view_chatbox" class="mt-2 mb-2 text-white">Back to chat room</a>
         <a href="index.php?ctrl=UserController&action=logout" class="mt-2 mb-2 text-white">Logout</a>
      </div>
   </div>

   <div class="col-10 p-0 pt-5 text-center bg-light">
      <div class="container">
         <div class="row">
            <table class="table table-striped table-bordered text-dark">
               <thead>
                  <tr>
                     <th scope="col">User id</th>
                     <th scope="col">User name</th>
                     <th scope="col">User email</th>
                     <th scope="col">Status</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  // while($set = $all_users->fetch()) :
                  for ($i = 0; $i < count($all_users); $i++) {
                     $set = $all_users[$i];
                     if (empty($set['is_admin'])) {
                        $set['is_admin'] = 'false';
                     }
                     if ($set['is_admin'] === 'false') 
                     {
                  ?>
                        <tr>
                           <th scope="row"><?php echo $i ?></th>
                           <td><?php echo $set['username'] ?></td>
                           <td><?php echo $set['email'] ?></td>
                           <td>
                              <a href="index.php?ctrl=UserController&action=view_profile&id=<?php echo $set['_id'] ?>" class="btn btn-sm btn-warning text-lg-center text-dark">Update</a>
                              <a href="index.php?ctrl=AdminController&action=remove_user&id=<?php echo $set['_id'] ?>" class="btn btn-sm btn-danger text-lg-center text-white ml-2">Delete</a>
                           </td>
                        </tr>
                  <?php }
                  } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>