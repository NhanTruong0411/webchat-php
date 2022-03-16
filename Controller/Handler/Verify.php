<?php

    $user = new User();

    if(!empty($_GET['code'])) {
        $verify_code = $_GET['code'];

        $result = $user->isVerifyEmailCode($verify_code);

        if(!empty($result)) {

            // var_dump($result[0]->_id);

            $param = array(
                'enable' => true
            );

            $user->update($result[0]->_id, $param);

            echo '<script>alert("Verify Success!!")</script>';
            echo "<meta http-equiv='refresh' content='0; url=index.php?ctrl=UserController&action=view_login' />";

        } else {
            echo '<script>alert("Something went wrong!")</script>';
        }
    }

?>