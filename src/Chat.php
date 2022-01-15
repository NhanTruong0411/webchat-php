<?php

namespace MyApp;

use DateTime;
use DateTimeZone;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__).'/Model/MongoConnection.php';
require dirname(__DIR__).'/Model/User.php';
require dirname(__DIR__).'/Model/Room.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data = json_decode($msg);

        $user = new \User;

        $room = new \Room;

        $temp = $user->getUserById($data->user_id);
        $user_detail = $user->tranformUserDetail('chat-detail',$temp);

        $date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
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