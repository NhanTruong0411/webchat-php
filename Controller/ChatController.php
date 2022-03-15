<?php

$action = 'view_chatbox';

if (isset($_GET['action']))
    $action = $_GET['action'];

$room = new Room;
$chat_users = new User();
$private_chat = new PrivateChat();

switch ($action) {
    case 'view_chatbox':
        include 'View/chatbox2.php';
        break;
    case 'view_private_chat':
        include 'View/privateChat2.php';
        if(isset($_GET['request_name'])) {
            $result = $private_chat->getAllPrivateChat($_POST['receiver_user_id'], $_POST['from_user_id']);
            var_dump($result);
        }
        break;
}
