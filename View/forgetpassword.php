<section class="ftco-section">
   <div class="container" style="height: 100vh;">
      <div class="row justify-content-center" style="height: 100vh;">
         <div class="col-md-6 col-lg-5 align-self-center">
            <div class="login-wrap py-5 bg-dark p-5">
               <h1 class="text-center my-5" style="font-size: 100px;">Hi there,</h1>
               <div class="my-5 pt-1">
                  <h3 class="text-center mb-0"></h3>
                  <p class="text-center mb-0">Forget your password? Enter your email address in the form below.</p>
               </div>
               <form action="index.php?ctrl=UserController&action=handle_register" class="login-form" method="POST">
                  <!-- Email -->
                  <div class="form-group">
                     <div class="row">
                        <div class="col-1">
                           <span class="fa fa-envelope mt-2 pt-1"></span>
                        </div>
                        <div class="col-11">
                           <input type="text" name="email" class="form-control" placeholder="Email" required>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn form-control btn-yellow rounded submit px-3 mt-4">Send</button>
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
