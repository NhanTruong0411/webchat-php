<?php
   $user = $_SESSION['user'];
   $_user = new User();
?>

<!-- heading -->
<div class="container text-center profile_heading" style="padding: 3em 0 0 0;">
   <div class="row justify-content-center">
      <div class="col-md-6 text-center mb-3">
         <h2 class="heading-section" style="font-size: 125px !important;">Contact Us</h2>
      </div>
   </div>
</div>

<div class="container text-center profile_main">
   <div class="row justify-content-center">
      <div class="mt-3 mb-3 text-center w-75">
         <div class="sent-notification" role="alert"></div>
         <form method="POST" id="myForm">

            <div class="form-group text-left ">
               <label for="name" class="text-dark">Your Name</label>
               <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group text-left ">
               <label for="email" class="text-dark">Your Email</label>
               <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group text-left ">
               <label for="subject" class="text-dark">Subject</label>
               <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group text-left ">
               <label for="message" class="text-dark">Message</label>
               <textarea class="form-control" rows="15" id="message" name="message" value="<?php echo $message; ?>" required></textarea>
            </div>
            <div class="row justify-content-center pb-5">
               <button type="submit" onclick="sendEmail()" class="btn btn-lg btn-info text-lg-center">Send</button>
               <a type="reset" href="index.php?ctrl=UserController&action=view_profile" class="btn btn-lg btn-danger text-lg-center mx-3 text-white">Reset</a>
               <?php
               if ($user['is_admin'] == "true") {
                  echo '<a href="index.php?ctrl=AdminController&action=view_dashboard" class="btn btn-lg btn-success text-lg-center text-white mr-3">Back to Dashboard</a>';
               }
               ?>
               <a href="index.php?ctrl=ChatController&action=view_chatbox" class="btn btn-lg btn-warning text-lg-center text-dark">Back to chat</a>
            </div>
         </form>
      </div>
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   function sendEmail() {
      var name = $('#name');
      var email = $('#email');
      var subject = $('#subject');
      var message = $('#message');

      if (isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(subject) && isNotEmpty(message)) {
         $.ajax({
            url: 'index.php?ctrl=UserController&action=handle_contact',
            method: 'POST',
            dataType: 'json',
            data: {
               name: name.val(),
               email: email.val(),
               subject: subject.val(),
               message: message.val()
            },
            success: function(response) {
               if (response.status == 'success') {
                  $('$myForm')[0].reset();
                  $('.sent-notification').html('Message sent successfully !');
                  // $('.sent-notification').add("alert-success");
                  name.val('');
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