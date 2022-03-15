<?php
class User
{
    private $Users_Collection;
    private $date;

    public function __construct()
    {
        //connect to db and get the Users collection
        $this->Users_Collection = MongoConnection::connect()->users;
        $this->date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
    }

    /**
     * Function find user in database
     *
     * @param string $type type of get user
     * @param array $input object user
     * @return void object that found in database
     */
    public function getUser(string $type = '', array $input = [])
    {

        //if register -> found the acount has
        //the same email in database
        if ($type === 'register') {
            $result = $this->Users_Collection->findOne(['email' => $input['email']]);
            return $result;
        }


        //if login -> found the account has the same email and password
        //that user has given
        if ($type === 'login') {
            $filter = array(
                'email' => $input['email'],
                'password' => $input['password']
            );
            $result = $this->Users_Collection->findOne($filter);
            return $result;
        }
    }

    /**
     * Undocumented function
     *
     * @param string $id
     * @return void
     */
    public function getUserById(string $id) {
        $result = $this->Users_Collection->findOne(['_id' => $this->mongo_id($id)]);
        return $result;
    }

    /**
     * Function write new user into database
     *
     * @param array $input user object
     * @return void return true if success
     */
    public function register(array $input = [])
    {
        $register_user = array(
            'email' =>  $input['email'],
            'username' => $input['username'],
            'password' => $input['password'],
            'login_status' => false,
            'create_at' => $this->date->format('d-m-Y h:i:s'),
            'update_at' => $this->date->format('d-m-Y h:i:s'),
            'avatar' => $this->generateAvatar(strtoupper($input['username'][0])),
            'is_admin' => false
        );
        $this->Users_Collection->insertOne($register_user);
        return true;
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
            ['_id' =>  $this->mongo_id($user_id)],
            ['$set' => $set]
        );
    }

    public function getAllUser()
    {
        $users = $this->Users_Collection->find()->toArray();

        $transformed_users = [];
        foreach($users as $user) 
        {
            $transformed_users[] = $this->tranformUserDetail('without-password', $user);
        }
        return $transformed_users;
    }

    public function removeUser() {
        $this->Users_Collection->deleteOne(['_id' => $this->mongo_id($_GET['id'])]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $user_detail
     * @return void
     */
    public function tranformUserDetail(string $type, $user_detail) {

        if($type == 'chat-detail') 
        {
            $new_user_detail = array(
                'user_id' => $user_detail['_id'],
                'username' => $user_detail['username'],
                'avatar' => $user_detail['avatar'],
                'connection_id' => $user_detail['connection_id']??""
            );
    
            return $new_user_detail;
        }

        if($type == 'without-password') 
        {
            unset($user_detail['password']);
            return $user_detail;
        }
    }

    private function generateAvatar($character)
    {
        $path = "images/avatar_" . time() . ".png";
        $image = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($image, $red, $green, $blue);

        $textcolor = imagecolorallocate($image, 255, 255, 255);

        $font = dirname(__FILE__) . '\font\arial.ttf';

        imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }

    private function mongo_id(string $id) {
        return new MongoDB\BSON\ObjectId($id);
    }

}
