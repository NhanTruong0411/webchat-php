<?php
$user = $_SESSION['user'];
$user_id = $user['user_id'];

if (!empty($_GET['id'])) {
   $user_id = $_GET['id'];
}

$_user = new User();
$user_info = $_user->getUserById($user_id);
?>
<!-- heading -->
<div class="container text-center profile_heading" style="padding: 3em 0 0 0;">
   <div class="row justify-content-center">
      <div class="col-md-6 text-center mb-3">
         <h2 class="heading-section" style="font-size: 125px !important;">User Profile</h2>
      </div>
   </div>
</div>

<form action="index.php?controller=UserController&action=handle_edit_profile" method="POST" enctype="multipart/form-data">
   <!-- avatar -->
   <div class="container text-center profile_avatar">
      <div class="row justify-content-center">
         <div class="mt-3 mb-3 text-center col-lg-5 col-md-6">
            <img src="<?php echo $user['avatar'] ?>" alt="user image" style="width: 150px; height: 150px; " class="img-fluid rounded-circle img-thumbnail" />
            <div>
               <h2>Hello, <?php echo $user['username']; ?></h2>
            </div>
            <div class="custom-file my-3">
               <input type="file" class="custom-file-input" id="customFile" name="avatar_name">
               <label class="custom-file-label" for="customFile">Change avatar</label>
            </div>
         </div>
      </div>
   </div>

   <!-- main profile -->
   <div class="container text-center profile_main">
      <div class="row justify-content-center">
         <div class="mt-3 mb-3 text-center w-75">
            <?php
            // while($set = $user_info->fetch());
            // var_dump($user_info['username']);
            ?>
            <!-- username -->
            <div class="form-group row">
               <label for="staticEmail" class="col-sm-3 col-form-label text-right mt-2">Username</label>
               <div class="col-sm-8">
                  <input type="text" class="form-control" style="color: #000 !important;" name="username" value="<?php echo $user_info['username'] ?>">
               </div>
            </div>
            <!-- old password -->
            <div class="form-group row">
               <label for="inputPassword" class="col-sm-3 col-form-label text-right mt-2">Password</label>
               <div class="col-sm-8">
                  <input type="password" class="form-control" style="color: #000 !important;" id="inputPassword" name="old_pass" placeholder="Old password">
               </div>
            </div>
            <!-- new password -->
            <div class="form-group row">
               <label for="inputNewPassword" class="col-sm-3 col-form-label text-right mt-2">New password</label>
               <div class="col-sm-8">
                  <input type="password" class="form-control" style="color: #000 !important;" id="inputNewPassword" name="new_pass" placeholder="New password">
               </div>
            </div>
            <!-- confirm new password -->
            <div class="form-group row">
               <label for="inputConfirmNewPassword" class="col-sm-3 col-form-label text-right mt-2">Confirm new password</label>
               <div class="col-sm-8">
                  <input type="password" class="form-control" style="color: #000 !important;" id="inputConfirmNewPassword" name="c_new_pass" placeholder="Confirm new password">
               </div>
            </div>
         </div>
      </div>
      <div class="row justify-content-center pb-5">
         <button type="submit" class="btn btn-lg btn-info text-lg-center">Submit</button>
         <a type="reset" href="index.php?ctrl=UserController&action=view_profile" class="btn btn-lg btn-danger text-lg-center mx-3 text-white">Reset</a>
         <?php
         if ($user['is_admin'] == "true") {
            echo '<a href="index.php?ctrl=AdminController&action=view_dashboard" class="btn btn-lg btn-success text-lg-center text-white mr-3">Back to Dashboard</a>';
         }
         ?>
         <a href="index.php?ctrl=ChatController&action=view_chatbox" class="btn btn-lg btn-warning text-lg-center text-dark">Back to chat</a>
      </div>
   </div>
</form>

<script>
   // Add the following code if you want the name of the file appear on select
   $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
   });
</script>