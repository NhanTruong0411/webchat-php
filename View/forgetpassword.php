<section class="ftco-section">
   <div class="container" style="height: 100vh;">
      <div class="row justify-content-center" style="height: 100vh;">
         <div class="col-md-6 col-lg-5 align-self-center">
            <div class="login-wrap py-5 bg-dark p-5">
               <h1 class="text-center my-5" style="font-size: 100px;">Hi there,</h1>
               <div class="my-5 pt-1">
                  <h3 class="text-center mb-0"></h3>
                  <p class="text-center mb-0">Forgot your password? Enter your email address in the form below and hit the button.</p>
               </div>
               <form action="index.php?ctrl=UserController&action=handle_forget_password" class="login-form" method="POST">
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
                  <!-- Submit btn -->
                  <div class="form-group">
                     <button type="submit" name="submit_email" class="btn form-control btn-yellow rounded submit px-3 mt-4" onclick="sendEmail()">Send</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   function sendEmail() {
      var email = $('#email');

      if (isNotEmpty(email)) {
         $.ajax({
            url: 'index.php?ctrl=UserController&action=handle_forget_password',
            method: 'POST',
            dataType: 'json',
            data: {
               email: email.val(),
               subject: subject.val(),
               message: message.val()
            },
            success: function(response) {
               if (response.status == 'success') {
                  $('$myForm')[0].reset();
                  $('.sent-notification').html('Message sent successfully !');
                  // $('.sent-notification').add("alert-success");
                  email.val('');
                  subject.val('');
                  message.val('');
               } else {
                  $('.sent-notification').html('Message not sent. Something go wrong, please try again !');
                  // $('.sent-notification').add("alert-danger");
               }
            }
         })
      }
   }

   function isNotEmpty(el) {
      if (el.val().length > 0) {
         return true;
      } else {
         el.addClass('border border-danger');
         return false;
      }
   }
</script>
