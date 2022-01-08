<?php
    class User {
        var $email = null;
        var $username = null;
        var $password = null;
        var $avatar = null;

        public function __construct()
        {
            
        }

        /**
         * Function find user in database
         *
         * @param string $type type of get user
         * @param array $input object user
         * @return void object that found in database
         */
        public function getUser(string $type = '',array $input = []) 
        {
            //connect to db and get the Users collection
            $users = MongoConnection::connect()->users;

            //if register -> found the acount has
            //the same email in database
            if($type === 'register')
            {
                $result = $users->findOne(['email' => $input['email']]);
                
                return $result;
            }

            //if login -> found the account has the same email and password
            //that user has given
            if($type === 'login')
            {
                $filter = array(
                    'email' => $input['email'],
                    'password' => $input['password']
                );
                $result = $users->findOne($filter);
                
                return $result;
            }

        }

        /**
         * Function write new user into database
         *
         * @param array $input user object
         * @return void return true if success
         */
        public function register(array $input = []) 
        {
            //connect to db and get the Users collection
            $users = MongoConnection::connect()->users;
            
            $users->insertOne($input);
            return true;
            // echo "Inserted with Object ID '{$result->getInsertedId()}'";
        }


    }
?>