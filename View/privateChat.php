<?php
$user = $_SESSION['user'];
$token = $user['token'];

$all_users = $chat_users->getAllUser('chat-detail');
?>

<div class="container-fluid">

	<div class="row">

		<!-- Column 1 : Profile -->
		<div class="col-md-1 col-sm-2 p-0 text-center" style=" height: 100vh; border-right:1px solid #ccc;">
			<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $user['user_id'] ?>" />
			<input type="hidden" name="is_active_chat" id="is_active_chat" value="No" />
			<div class="card d-flex flex-column text-center" style="background-color: #F9AA33 !important; border:none !important">
				<img src="<?php echo $user['avatar'] ?>" alt="" width="100" class="img-fluid rounded-circle img-thumbnail mx-auto my-3" />
				<?php
				if ($user['is_admin'] == "false") {
					echo '';
				}
				?>
				<?php
				if ($user['is_admin'] == "true") {
					echo '<a href="index.php?ctrl=AdminController&action=view_dashboard" class="mt-2 mb-2 text-white">Dashboard</a>';
				}
				?>
				<a href="index.php?ctrl=UserController&action=view_profile" class="mt-2 mb-2 text-white">Edit</a>
				<a href="index.php?ctrl=ChatController&action=view_chatbox" class="mt-2 mb-2 text-white">Group Chat</a>
				<?php
				if (!$user['is_admin']) {
					echo '<a href="index.php?ctrl=UserController&action=view_contact" class="mt-2 mb-2 text-white">Contact us</a>';
				}
				?>
				<a href="index.php?ctrl=UserController&action=logout" class="mt-2 mb-2 text-white">Log out</a>
			</div>
		</div>

		<!-- Column 2 : friend list -->
		<!-- Column 2 : friend list -->
		<div class="col-md-3 col-sm-4 p-0">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id'] ?>">
			<div class="card" style="height: 100vh !important;">
				<div class="card-header text-white" style="background-color: #344955;">
					<h3 class="m-0 text-left text-white">User List</h3>
				</div>
				<div class="card-body" id="user_list" style="background-color: #3c4146;">
					<div class="list-group list-group-flush">
						<?php
						if (count($all_users) > 0) {
							foreach ($all_users as $k => $u) {
								$status = '<i class="fa fa-circle text-danger"></i>';
								if ($u['login_status']) {
									$status = '<i class="fa fa-circle text-success"></i>';
								}

								if ($u['_id'] != $user['user_id']) {
									echo "
								<a class='list-group-item list-group-item-action select_user ' style='cursor:pointer' data-user_id = '" . $u['_id'] . "'>
											<img src='" . $u["avatar"] . "' class='img-fluid rounded-circle img-thumbnail' width='50' />
											<span class='ml-1'>
											<strong>
													<span id='list_user_name_" . $u["_id"] . "'>" . $u['username'] . "</span>
													<span id='friend_id" . $u['_id'] . "' value='" . $u['_id'] . "'></span>
											</strong>
											</span>
											<span class='mt-2 float-right' id='users_status" . $u['_id'] . "'>" . $status . "</span>
										</a>
								";
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
							<h3 class="m-0 text-left text-white">Private Chat Room</h3>
						</div>
					</div>
				</div>

				<div class="card-body" id="messages_area" style="background-color: #3c4146;">
					<div id="chat_area"></div>
				</div>
			</div>


		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {

			//join room
			// $('[id^=userid_]').on('click', function() {
			// 	var selected_userid = $(this).attr('id').split('_')[1];
			// 	var current_login_userid = $('#user_id').val();
			// 	var room_name = `${selected_userid}!@!@2@!@!${current_login_userid}`

			// 	conn.onopen(room_name);
			// })

			var from_user_id = $('#login_user_id').val();

			var receiver_user_id = '';

			var conn = new WebSocket('ws://localhost:8080?token=<?php echo $token; ?>&user_id=<?php echo $user['user_id']; ?>');
			conn.onopen = function(e) {
				console.log("Connection established!");
			};

			conn.onmessage = function(event) {
				//lấy dữ liệu từ ratchet server
				var data = (event.data);

				data = JSON.parse(data);
				console.log(data);

				var row_class = "";
				var background_class = "";
				if (data.from == 'Me') {
					row_class = 'row justify-content-start';
					background_class = 'alert-primary';
				} else {
					row_class = 'row justify-content-end';
					background_class = 'alert-success';
				}

				if (from_user_id == data.from_user_id || data.from == 'Me') {
					if ($('#is_active_chat').val() == 'Yes') {
						var html_data = `
						<div class="` + row_class + `">
							<div class="col-sm-10">
								<div class="shadow-sm alert ` + background_class + `">
									<b>` + data.from + ` - </b>` + data.message + `<br />
									<div class="text-right">
										<small><i>` + data.sent_time + `</i></small>
									</div>
								</div>
							</div>
						</div>
						`;

						$('#messages_area').append(html_data);

						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

						$('#chat_message').val("");
					}
				}

				if ($('#chat_user_name') != data.from) {
					var count_chat = $('#unread').text();
					if (count_chat == '') {
						count_chat = 0;
					}
					count_chat = parseInt(count_chat);
					count_chat = count_chat + 1;

					$('#unread').text(count_chat);
					$('#unread').show();
				}

			}

			conn.onclose = function(event) {
				console.log("Connection close!");
			}


			// Hàm tạo và tải tin nhắn xuống hiển thị từ server mysql và nằm trong ($(document).on('click', '.select_user', function() {..})
			function make_chat_box(receiver_username, friend_user_id) {
				var html_data = `
		<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-sm-6">
							<b><span class="text-white" id="chat_user_name">` + receiver_username + `</span></b>

							</div>
						<div class="col col-sm-6 text-right">
							<button type="button" class="close" id="close_chat_area" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
				<div class="card-body" id="messages_area" style="height:65vh">

				</div>
			</div>

			<form id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
			<input type="hidden" id="chat_user_id" value="` + friend_user_id + `">

				<div class="input-group mb-3" style="height:10vh">
					<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000"  required></textarea>
					<div class="input-group-append">
						<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>
				<div id="validation_error"></div>
				<br />
			</form>
		`;
				$('#chat_area').html(html_data);

				$('#chat_form').parsley();
			};

			$(document).on('click', '.select_user', function() {
				receiver_user_id = $(this).data('user_id');

				var receiver_usename = $('#list_user_name_' + receiver_user_id).text();

				$('.select_user.active').removeClass('active');
				$(this).addClass('active');

				make_chat_box(receiver_usename, receiver_user_id);

				$('#is_active_chat').val('Yes');

				$.ajax({
					url: "index.php?ctrl=ChatController&action=view_private_chat&request_name=fetch_chat",
					method: "POST",
					data: {
						request_name: 'fetch_chat',
						receiver_user_id,
						from_user_id
					},
					dataType: "json",

					//nhận dữ liệu từ server ratchet gửi xuống và hiển thị lên
					success: function(data) {
						if (data.length > 0) {
							var html_data = '';
							for (var i = 0; i < data.length; i++) {
								var row_class = '';
								var background_class = '';
								var user_name = '';

								if (data[i].from_user_id == user_id) {
									row_class = 'row justify-content-start';
									background_class = 'alert-primary';
									user_name = 'Me';
								} else {
									row_class = 'row justify-content-end';
									background_class = 'alert-success';
									user_name = data[i].from_user_name;
								}
								html_data += `
							<div class="` + row_class + `">
								<div class="col-sm-10">
									<div class="shadow alert ` + background_class + `">
										<b>` + user_name + ` - </b>
										` + data[i].message + `<br />
										<div class="text-right">
											<small><i>` + data[i].timestamp + `</i></small>
										</div>
									</div>
								</div>
							</div>
							`;
							}
						}
						$('#friend_id' + friend_user_id).html(0);
						$('#messages_area').html(html_data);
						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
					}

				})

			})

			//Hàm gửi tin nhắn phía client lên server ratchet
			$(document).on('submit', '#chat_form', function(event) {
				event.preventDefault();

				if ($('#chat_form').parsley().isValid()) {
					var from_user_id = $('#login_user_id').val();
					var message = $('#chat_message').val();
					var receiver_user_id = $('#chat_user_id').val();
					var data = {
						from_user_id,
						message,
						receiver_user_id,
						command: 'private_chat'
					}
					conn.send(JSON.stringify(data));
				}
			})

			$(document).on('click', '#close_chat_area', function() {
				$('#chat_area').html('');
				$('.select_user.active').removeClass('active');
				$('#is_active_chat').val('No');

				receiver_user_id = '';
			});
		})
	</script>