<?php
if(isset($_GET['key']))
   $key = $_GET['key'];
?>

<section class="ftco-section">
   <div class="container" style="height: 100vh;">
      <div class="row justify-content-center" style="height: 100vh;">
         <div class="col-md-6 col-lg-5 align-self-center">
            <div class="login-wrap py-5 bg-dark p-5">
               <h1 class="text-center my-5" style="font-size: 90px;">Hi again,</h1>
               <div class="my-5 pt-1">
                  <h3 class="text-center mb-0"></h3>
                  <p class="text-center mb-0">Enter your new password and confirm it once more time to reset you password. </p>
               </div>
               <form action="index.php?ctrl=UserController&action=handle_reset_password" class="login-form" method="POST">
                  <input type="hidden" value="<?php echo $key ?>" name="key">
                  <!-- Password -->
                  <div class="form-group">
                     <div class="row">
                        <div class="col-1">
                           <span class="fa fa-lock mt-2 pt-1"></span>
                        </div>
                        <div class="col-11">
                           <input type="password" name="pass" class="form-control" placeholder="New password" required>
                        </div>
                     </div>
                  </div>
                  <!-- Confirm Password -->
                  <div class="form-group">
                     <div class="row">
                        <div class="col-1">
                           <span class="fa fa-lock mt-2 pt-1"></span>
                        </div>
                        <div class="col-11">
                           <input type="password" name="c-pass" class="form-control" placeholder="Confirm new password" required>
                        </div>
                     </div>
                  </div>
                  <!-- Submit btn -->
                  <div class="form-group">
                     <button type="submit" name="submit_reset" class="btn form-control btn-yellow rounded submit px-3 mt-4">Send</button>
                  </div>
               </form>
               <div class="w-100 text-center mt-5 text">
                  <a href="index.php?ctrl=UserController&action=view_login">Log In</a>
                  <a href="index.php?ctrl=UserController&action=view_register" class="ml-3">Register</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>