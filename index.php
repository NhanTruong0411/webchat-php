<?php 
  include 'Model/MongoConnection.php';
  include 'Model/User.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link id="theme" rel="stylesheet" href="css/chatbox/style.css">
  <link rel="stylesheet" href="public/css/chatbox/main.css">
  <link rel="stylesheet" href="public/css/login/css/style.css">
  <title>WebChat</title>
</head>

<body>

  <?php

    $ctrl = "UserController";

    if(isset($_GET['route'])) {
      $ctrl = $_GET['route'];
    }

    include 'Controller/' . $ctrl . '.php';

  ?>


  <script src="public/js/chatbox/jQuery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="public/js/chatbox/chat.js"></script>
  
	<script src="public/js/login/"></script>
	<script src="public/js/login/popper.js"></script>
	<script src="public/js/login/bootstrap.min.js"></script>
	<script src="public/js/login/main.js"></script>
</body>

</html>