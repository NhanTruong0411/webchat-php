<?php
    
    // require_once '../vendor/autoload.php';

    require_once __DIR__. '\\..\\'."/vendor/autoload.php";

    use MongoDB\Client;

    /**
     * Function connect to database
     */
    class MongoConnection 
    {
        static $db = null;
        static function connect()
        {
            $uri = "mongodb://localhost:27017";
            
            $conn = new Client($uri);
            
            // seff::db = $conn->selectDatabase('webchat');
            self::$db = $conn->webchat;

            return self::$db;
        }
    }

?>