<section class="ftco-section">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Register</h2>
         </div>
      </div>
      <div class="row justify-content-center">
         <div class="col-md-6 col-lg-4">
            <div class="login-wrap py-5">
               <div class="img d-flex align-items-center justify-content-center" style="background-image: url(public/css/login/images/bg.png); width: 250px; height: 200px"></div>
               <h3 class="text-center mb-0">Welcome</h3>
               <p class="text-center">Sign up by entering the information below</p>
               <form action="index.php?ctrl=UserController&action=handle_register" class="login-form" method="POST">
                  <!-- Email Address -->
                  <div class="form-group">
                     <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span>
                     </div>
                     <input type="text" name="email" class="form-control" placeholder="Email Address" required>
                  </div>
                  <!-- User name -->
                  <div class="form-group">
                     <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span>
                     </div>
                     <input type="text" name="username" class="form-control" placeholder="Username" required>
                  </div>
                  <!-- Password -->
                  <div class="form-group">
                     <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span>
                     </div>
                     <input type="password" name="password" class="form-control" placeholder="Password" required>
                  </div>

                  <div class="form-group">
                     <button type="submit" class="btn form-control btn-primary rounded submit px-3 mt-4">Register</button>
                  </div>
               </form>
               <div class="w-100 text-center mt-4 text">
                  <p class="mb-0">Back to log in?</p>
                  <a href="index.php?ctrl=UserController&action=view_login">LOG IN</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>