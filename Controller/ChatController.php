<?php 

    $action = 'view_chatbox';

    if(isset($_GET['action']))
        $action = $_GET['action'];
    
    switch($action) {
        case 'view_chatbox':
            include 'View/chatbox.php';
            break;
    }
