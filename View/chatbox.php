<?php
$user = $_SESSION['user'];
?>

<div class="container-fluid h-100">
  <!-- profile on top of page -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="mt-3 mb-3 text-center">
        <img src="<?php echo $user['avatar'] ?>" alt="" width="150" class="img-fluid rounded-circle img-thumbnail" />
        <h3><?php echo $user['username'] ?></h3>
        <div>
          <a class="btn btn-info mt-2 mb-2 text-white">Edit</a>
          <a href="index.php?ctrl=UserController&action=logout" class="btn btn-danger mt-2 mb-2 text-white">Logout</a>
        </div>
      </div>
    </div>
  </div>


  <!-- contact list left hand side -->
  <div class="row justify-content-center h-100">
    <div class="col-md-4 col-xl-3 chat">
      <div class="card mb-sm-3 mb-md-0 contacts_card">
        <div class="card-header">
          <div class="input-group">
            <input type="text" placeholder="Search..." name="" class="form-control search">
            <div class="input-group-prepend">
              <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
            </div>
          </div>
        </div>
        <div class="card-body contacts_body">
          <ul class="contacts">
            <li class="active">
              <div class="d-flex bd-highlight">
                <div class="img_cont">
                  <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                  <span class="online_icon"></span>
                </div>
                <div class="user_info">
                  <span>Khalid</span>
                  <p>Kalid is online</p>

                </div>
              </div>
            </li>
            <li>
              <div class="d-flex bd-highlight">
                <div class="img_cont">
                  <img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img">
                  <span class="online_icon offline"></span>
                </div>
                <div class="user_info">
                  <span>Taherah Big</span>
                  <p>Taherah left 7 mins ago</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>


    <!-- Chat box right hand side -->
    <div class="col-md-8 col-xl-6 chat">
      <div class="card">
        <!-- frist section : tool container -->
        <div class="card-header msg_head">
          <div class="d-flex bd-highlight">
            <div class="img_cont">
              <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
              <span class="online_icon"></span>
            </div>
            <div class="user_info">
              <span>Chat with Khalid</span>
              <p>1767 Messages</p>
            </div>
            <div class="video_cam">
              <span><i class="fas fa-video"></i></span>
              <span><i class="fas fa-phone"></i></span>
            </div>
          </div>
          <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
          <!-- dropdown menu -->
          <div class="action_menu">
            <ul>
              <li><i class="fas fa-user-circle"></i> View profile</li>
              <li><i class="fas fa-users"></i> Add to close friends</li>
              <li><i class="fas fa-plus"></i> Add to group</li>
              <li><i class="fas fa-ban"></i> Block</li>
            </ul>
          </div>
        </div>

        <!-- Second section : message container -->
        <div class="card-body msg_card_body">
          <!-- people message -->
          <div class="d-flex justify-content-start mb-4">
            <div class="img_cont_msg">
              <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
            </div>
            <div class="msg_cotainer">
              Hi, how are you samim?
              <span class="msg_time">8:40 AM, Today</span>
            </div>
          </div>
          <!-- your message -->
          <div class="d-flex justify-content-end mb-4">
            <div class="msg_cotainer_send">
              Hi Khalid i am good tnx how about you?
              <span class="msg_time_send">8:55 AM, Today</span>
            </div>
            <div class="img_cont_msg">
              <img src="./images/1641822823.png" class="rounded-circle user_img_msg">
            </div>
          </div>
        </div>

        <!-- Third section : type your message... container -->
        <div class="card-footer">
          <div class="input-group">
            <div class="input-group-append">
              <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
            </div>
            <textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
            <div class="input-group-append">
              <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#action_menu_btn').click(function() {
      $('.action_menu').toggle();
    });
  });

  var conn = new WebSocket('ws://localhost:8080');
  conn.onopen = function(e) {
    console.log("Connection established!");
  };

  conn.onmessage = function(e) {
    console.log(e.data);
  };
</script>