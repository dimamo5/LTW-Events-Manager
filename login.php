<?php
    session_start();
    include_once('databaseConnection.php');
    if(login_check()){
        header("Location:index.php");
    }
?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Diogo Moura">

    <title>Event Maganger</title>

<link rel="stylesheet" type="text/css" href="css/login.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/login.js"></script>



</head>

<body>

<div class="logo">Event Manager</div>
<div class="login-block">

    <form id="login-form" method="post">
        <h2 >Please sign in</h2>
        <input id="username" name="username" type="text" placeholder="Username" required="" autofocus="">
        <input id="password" name="password" type="password" placeholder="Password" required="">

        <button type="submit">Sign in</button>
        
    </form>
    <a href="register.php">Register</a>
        
</div>

</body>
</html>