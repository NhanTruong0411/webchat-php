<?php

class privateChat
{
    private $PrivateChat_Collection;

    public function __construct()
    {
        $this->PrivateChat_Collection = MongoConnection::connect()->privatechats;
    }

    public function getAllPrivateChat($receiver_user_id, $from_user_id)
    {
        return $this->PrivateChat_Collection->find()->toArray();
    }

    public function saveMessage($message_detail) 
    {
        $result = $this->PrivateChat_Collection->insertOne($message_detail);
        return $result->getInsertedId();
    }

    public function updateMessageStatus($private_chat_message_id, $status)
    {
        $this->PrivateChat_Collection->findOneAndUpdate(
            ['id' => $this->mongo_id($private_chat_message_id)],
            ['$set' => 
                [
                    'status' => $status
                ]
            ]
        );
    }

    private function mongo_id(string $id) {
        return new MongoDB\BSON\ObjectId($id);
    }

}

?>