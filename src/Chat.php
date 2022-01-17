<?php

namespace MyApp;

use DateTime;
use DateTimeZone;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__).'/Model/MongoConnection.php';
require dirname(__DIR__).'/Model/User.php';
require dirname(__DIR__).'/Model/Room.php';
require dirname(__DIR__).'/Model/PrivateChat.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        //get query string from http request
        $query_string = $conn->httpRequest->getUri()->getQuery();
        echo $query_string;
        if(!empty($query_string)) {
            parse_str($query_string, $query_array);
            // $query_array [
            //     'token' => ....,
            //     'user_id' => ....,
            // ]
    
            $user = new \User;
    
            $update = [
                'token' => $query_array['token'],
                'connection_id' => $conn->resourceId
            ];
    
            $user->update($query_array['user_id'], $update);
            echo "New connection! ({$conn->resourceId})\n";
        }
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data = json_decode($msg);

        $date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));

        if($data->command == 'private_chat')
        {

            //Private chat
            $private_chat = new \PrivateChat;

            $saved_message = array(
                'from_user_id' => $data->from_user_id,
                'receiver_user_id' => $data->receiver_user_id,
                'message' => $data->message,
                'create_at' => $date->format('d-m-Y h:i:s'),
                'status' => true
            );

            $private_chat_mesasge_id = $private_chat->saveMessage($saved_message);

            $user = new \User;

            $temp_from_user_data = $user->getUserById($data->from_user_id);
            $from_user_data = $user->tranformUserDetail('chat-detail',$temp_from_user_data);

            $temp_receiver_user_data = $user->getUserById($data->receiver_user_id);
            $receiver_user_data = $user->tranformUserDetail('chat-detail', $temp_receiver_user_data);

            $from_username = $from_user_data['username'];
            $receiver_connection_id = $receiver_user_data['connection_id'];

            $data->sent_time = $date->format('d-m-Y h:i:s');

            foreach ($this->clients as $client) {
                if($from == $client) {
                    $data->from = 'Me';
                } else {
                    $data->from = $from_username;
                }

                if(
                    $client->resourceId == $receiver_connection_id
                    ||
                    $from == $client
                )
                {
                    $client->send(json_encode($data));
                }
                else
                {
                    $private_chat->updateMessageStatus($private_chat_mesasge_id, false);
                }
    
            }

        }
        else 
        {
            //Group chat
            $user = new \User;
            $room = new \Room;

            $temp = $user->getUserById($data->user_id);
            $user_detail = $user->tranformUserDetail('chat-detail',$temp);
    
            $data->sent_time = $date->format('d-m-Y h:i:s');
    
            $saved_message = array(
                'user_id' => $data->user_id,
                'username' => $user_detail['username'],
                'message' => $data->message,
                'create_at' => $date->format('d-m-Y h:i:s'),
            );
    
            $room->saveMessage($saved_message);
    
            foreach ($this->clients as $client) {
                // if ($from !== $client) {
                //     // The sender is not the receiver, send to each client connected
                //     $client->send($msg);
                // }
    
                if($from == $client) {
                    $data->from = 'Me';
                } else {
                    $data->from = $user_detail['username'];
                }
    
                $client->send(json_encode($data));
            }

        }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>