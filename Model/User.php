<?php
    class User {
        var $email = null;
        var $username = null;
        var $password = null;
        var $avatar = null;

        public function __construct()
        {
            
        }

        public function getUser() 
        {
            $db = MongoConnection::connect();

            //$users = $db->select
            $users = $db->users->find()->toArray();
            foreach($users as $u) {
                echo $u->name;
            }
        }

        public function register($input) 
        {
            $users = MongoConnection::connect()->users;

            $result = $users->insertOne($input);

            // echo "Inserted with Object ID '{$result->getInsertedId()}'";
        }

        public function login($input)
        {

        }

    }
?>