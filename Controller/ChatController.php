<?php

$action = 'view_chatbox';

if (isset($_GET['action']))
    $action = $_GET['action'];

$room = new Room;

$chat_users = new User();

switch ($action) {
    case 'view_chatbox':
        include 'View/chatbox.php';
        break;
}
