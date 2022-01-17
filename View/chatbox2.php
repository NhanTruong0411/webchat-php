<?php 

   $user = $_SESSION['user'];

   $all_messages = $room->getAllMessage();

   $all_users = $chat_users->getAllUser();

?>

<div class="container">
   <br />
   <h3 class="text-center">PHP Chat Application</h3>
   <br />
   <div class="row">
      <!-- Chat box -->
      <div class="col-lg-8">
         <div class="card">

            <div class="card-header">
               <div class="row">
                  <div class="col col-sm-6">
                     <h3>Chat Room</h3>
                  </div>
                  <div class="col col-sm-6 text-right">
                     <a href="index.php?ctrl=ChatController&action=view_private_chat" class="btn btn-success btn-sm">Private Chat</a>
                  </div>
               </div>
            </div>

            <div class="card-body" id="messages_area">
               <?php
                  foreach($all_messages as $message) 
                  {
                     if(strcmp($message['user_id'], $user['user_id']))
                     {
                        $from = 'Me';
                        $row_class = 'row justify-content-start';
                        $background_class = 'text-dark alert-light';
                     }
                     else 
                     {
                        $from = $message['username'];
                        $row_class = 'row justify-content-end';
                        $background_class = 'alert-success';
                     }

                     echo '
                        <div class="'.$row_class.'">
                           <div class="col-sm-10">
                              <div class="shadow-sm alert '.$background_class.'">
                                 <b>'.$from.'</b> '. $message['message'] . '
                                 </br>
                                 <div class="text-right">
                                    <small>'.$message['create_at'].'</small>
                                 </div>
                              <div>
                           </div>
                        </div>
                     ';
                  }
               ?>
            </div>
            
            <form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
               <div class="input-group mb-3">
                  <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
                  <div class="input-group-append">
                     <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                  </div>
               </div>
               <div id="validation_error"></div>
            </form>

         </div>
      </div>

      <!-- Profile -->
      <div class="col-lg-4">
         <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id'] ?>">
         <div class="mt-3 mb-3 text-center">
            <img src="<?php echo $user['avatar'] ?>" alt="" width="150" class="img-fluid rounded-circle img-thumbnail" />
            <h3><?php echo $user['username'] ?></h3>
            <div>
               <a class="btn btn-info mt-2 mb-2 text-white">Edit</a>
               <a href="index.php?ctrl=UserController&action=logout" class="btn btn-danger mt-2 mb-2 text-white">Logout</a>
            </div>
         </div>

         <div class="card mt-3">
            <div class="card-header">User List</div>
            <div class="card-body" id="user_list">
               <div class="list-group list-group-flush">
                  <?php
                  if(count($all_users) > 0)
                  {
                     foreach($all_users as $k => $u)
                     {
                        $status = '<i class="fa fa-circle text-danger"></i>';
                        if($u['login_status']) 
                        {
                           $status = '<i class="fa fa-circle text-success"></i>';
                        }

                        if($u['_id'] != $user['user_id'])
                        {
                           echo '
                              <a class="list-group-item list-group-item-action">
                                 <img src="'.$u['avatar'].'" class="img-fluid rounded-circle img-thumbnail" width="50" />
                                 <span class="ml-1"><strong>'.$u['username'].'</strong></span>
                                 <span class="mt-2 float-right">'.$status.'</span>
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

         if(data.from == 'Me') {
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
         if($('#chat_form').parsley().isValid()) {

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