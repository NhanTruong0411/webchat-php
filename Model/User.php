<?php
    class User {
        public $Users_Collection;

        public function __construct()
        {
            //connect to db and get the Users collection
            $this->Users_Collection = MongoConnection::connect()->users;
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
            //if register -> found the acount has
            //the same email in database
            try {
                if($type === 'register')
                {
                    $result = $this->Users_Collection->findOne(['email' => $input['email']]);
                    
                    return $result;
                }
            } catch (\MongoDB\Exception $e) {
                echo "Exception:", $e->getMessage(), "\n";
            }

            //if login -> found the account has the same email and password
            //that user has given
            try {
                if($type === 'login')
                {
                    $result = $this->Users_Collection->findOne(['email' => $input['email']]);

                    if($result['password'] === $input['password']) {
                        return $result;
                    } else {
                        return false;
                    }
                }
            } catch (\MongoDB\Exception $e) {
                echo "Exception:", $e->getMessage(), "\n";
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
            try {
                $register_user = array(
                    'email' =>  $input['email'],
                    'username' => $input['username'],
                    'password' => $input['password'],
                    'login_status' => false,
                    'create_at' => new MongoDB\BSON\UTCDateTime(),
                    'update_at' => new MongoDB\BSON\UTCDateTime(),
                    'avatar' => $this->generateAvatar(strtoupper($input['username'][0]))
                );
                $this->Users_Collection->insertOne($register_user);
                return true;
                // echo "Inserted with Object ID '{$result->getInsertedId()}'";
            } catch (\MongoDB\Exception $e) {
                echo "Exception:", $e->getMessage(), "\n";
            }
        }

        /**
         * Undocumented function
         *
         * @param string $user_id
         * @param array $set
         * @return void
         */
        public function update(string $user_id, array $set)
        {
            // var_dump($set);
            $this->Users_Collection->findOneAndUpdate(
                ['_id' =>  new MongoDB\BSON\ObjectId($user_id)],
                ['$set' => $set]
            );
        }

        private function generateAvatar($character) 
        {
            $path = "images/".time().".png";
            $image = imagecreate(200, 200);
            $red = rand(0, 255);
            $green = rand(0, 255);
            $blue = rand(0, 255);
            imagecolorallocate($image, $red, $green, $blue);

            $textcolor = imagecolorallocate($image, 255, 255, 255);

            $font = dirname(__FILE__).'\font\arial.ttf';

            imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
            imagepng($image, $path);
            imagedestroy($image);
            return $path;
        }
    }
?>