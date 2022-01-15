<?php 

class Room 
{

    private $Rooms_Collection;
    private $date;

    public function __construct()
    {
        $this->Rooms_Collection = MongoConnection::connect()->rooms;
        $this->date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
    }

    public function saveMessage(array $data) 
    {
        $this->Rooms_Collection->insertOne($data);
    }

    public function getAllMessage()
    {
        return $this->Rooms_Collection->find()->toArray();
    }

}


?>