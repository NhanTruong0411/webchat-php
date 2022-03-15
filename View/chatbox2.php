<?php

$user = $_SESSION['user'];

$all_messages = $room->getAllMessage();

$all_users = $chat_users->getAllUser();

?>

<div class="container-fluid">
   <div class="row h-100">

      <!-- Column 1 : Profile -->
      <div class="col-md-1 col-sm-2 p-0 text-center">
         <div class="card d-flex flex-column" style="height: 100vh !important; background-color: #F9AA33 !important;">
            <img src="<?php echo $user['avatar'] ?>" alt="" width="100" class="img-fluid rounded-circle img-thumbnail mx-auto my-3" />
            <?php
               if($user['is_admin'] == "false") {
                  echo '';
               }
            ?>
            <?php
               if($user['is_admin'] == "true") {
                  echo '<a href="index.php?ctrl=AdminController&action=view_dashboard" class="mt-2 mb-2 text-white">Dashboard</a>';
               }
            ?>
            <a href="index.php?ctrl=UserController&action=view_profile" class="mt-2 mb-2 text-white">Edit</a>
            <a href="index.php?ctrl=ChatController&action=view_private_chat" class="mt-2 mb-2 text-white">Private Chat</a>
            <a href="index.php?ctrl=UserController&action=logout" class="mt-2 mb-2 text-white">Log out</a>
         </div>
      </div>

      <!-- Column 2 : friend list -->
      <div class="col-md-3 col-sm-4 p-0">
         <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id'] ?>">
         <div class="card" style="height: 100vh !important;">
            <div class="card-header text-white" style="background-color: #344955;">
               <h3 class="m-0 text-left text-white">User List</h3>
            </div>
            <div class="card-body" id="user_list">
               <div class="list-group list-group-flush">
                  <?php
                  if (count($all_users) > 0) {
                     foreach ($all_users as $k => $u) {
                        $status = '<i class="fa fa-circle text-danger"></i>';
                        if ($u['login_status']) {
                           $status = '<i class="fa fa-circle text-success"></i>';
                        }

                        if ($u['_id'] != $user['user_id']) {
                           echo '
                              <a class="list-group-item list-group-item-action">
                                 <img src="' . $u['avatar'] . '" class="img-fluid rounded-circle img-thumbnail" width="50" />
                                 <span class="ml-1"><strong>' . $u['username'] . '</strong></span>
                                 <span class="mt-2 float-right">' . $status . '</span>
                              </a>
                           ';
                        }
                     }
                  }
                  ?>
               </div>
            </div>
         </div>
      </div>

      <!-- Column 3 : Chat box -->
      <div class="col-md-8 col-sm-6 p-0">
         <div class="card" style="height: 100vh !important;">

            <div class="card-header text-white" style="background-color: #344955;">
               <div class="row">
                  <div class="col col-sm-6">
                     <h3 class="m-0 text-left text-white">Group Chat Room</h3>
                  </div>
               </div>
            </div>

            <div class="card-body" id="messages_area">
               <?php
               foreach ($all_messages as $message) {
                  if (strcmp($message['user_id'], $user['user_id'])) {
                     $from = 'Me';
                     $row_class = 'row justify-content-start';
                     $background_class = 'text-dark alert-light';
                  } else {
                     $from = $message['username'];
                     $row_class = 'row justify-content-end';
                     $background_class = 'alert-success';
                  }

                  echo '
                        <div class="' . $row_class . '">
                           <div class="col-sm-10">
                              <div class="shadow-sm alert ' . $background_class . '">
                                 <b>' . $from . '</b> ' . $message['message'] . '
                                 </br>
                                 <div class="text-right">
                                    <small>' . $message['create_at'] . '</small>
                                 </div>
                              <div>
                           </div>
                        </div>
                     ';
               }
               ?>
            </div>

            <form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
               <div id="validation_error"></div>
               <div class="input-group">
                  <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
                  <div class="input-group-append">
                     <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                  </div>
               </div>
            </form>

         </div>
      </div>



   </div>
</div>

<script type="text/javascript">
   $(document).ready(function() {

      //connect to socket
      var conn = new WebSocket('ws://localhost:8080');
      conn.onopen = function(e) {
         console.log("Connection established!");
      };

      conn.onmessage = function(e) {

         var data = JSON.parse(e.data);
         console.log(e.data);

         var row_class = '';

         var background_class = '';

         if (data.from == 'Me') {
            row_class = 'row justify-content-start';
            background_class = 'text-dark alert-light';
         } else {
            row_class = 'row justify-content-end';
            background_class = 'alert-success';
         }

         var html_data = `
            <div class='${row_class}'>
               <div class='col-sm-10'>
                  <div class='shadow-sm alert ${background_class}'>
                     <b>${data.from}</b>
                     ${data.message}
                     <br/>
                     <div class='text-right'>
                        <small>${data.sent_time}</small>
                     </div>
                  </div>
               </div>
            </div>
         `;

         $('#messages_area').append(html_data);

         $('#chat_message').val('');

         console.log(data);
      };

      //initialize parsley validation library
      $('#chat_form').parsley();

      // $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

      //chat form submit
      $('#chat_form').on('submit', function(e) {

         //stop refresh
         e.preventDefault();

         //check validate
         if ($('#chat_form').parsley().isValid()) {

            var user_id = $('#user_id').val();
            var message = $('#chat_message').val();

            var data = {
               user_id,
               message
            }

            conn.send(JSON.stringify(data));

            // $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

         }

      })

   })
</script>