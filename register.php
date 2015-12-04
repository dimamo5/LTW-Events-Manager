<?php
    session_start();
    include_once 'databaseConnection.php';
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
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/login.js"></script>


</head>

<body>

<div class="logo">Event Manager</div>
<div class="register-block">

    <form id="register-form" method="post">
        <h2 >Please sign up</h2>
        <input id="username" name="username" type="text" placeholder="Username" required="" autofocus="">
		<input id="email" name="email" type="email" placeholder="Email" required="">
		<input id="name" name="name" type="text" placeholder="Name" required="">
		<input id="birthday" name="birthday" type="date" placeholder="Birthday" required="">
        <input id="password" name="password" type="password" placeholder="Password" required="">
		<input id="password2" type="password" placeholder="Verify Password" required="">

        <button type="submit">Sign up</button>
        
    </form>
    
</div>

</body>
</html>