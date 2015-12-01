<?php
    session_start();
	include_once 'databaseConnection.php';
	if(!login_check()){
		header("Location:login.php");
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
	
	<link rel="shortcut icon" href="static/website/logo.png">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/eventManager.css">
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/eventManager.js"></script>


</head>
<body>
<div id="hmenu">
	<div id="containerNavBar">
		
		<ul class="nav">
			<a href="index.php"><img id="logo" src="static/website/logo.png"></img></a>
			<li id="search">
				<form action="" method="get">
					<input type="text" name="search_text" id="search_text" placeholder="Search" />
					<button type="submit" name="search_button" id="search_button"><i class="fa fa-search"></i></button>
				</form>
			</li>
			<li id="options">
				<a href="#">Options  <i class="fa fa-arrow-down"></i></a>
				<ul class="subnav">
					<li><a href="#">Settings</a></li>
					<li><a href="#">Application</a></li>
					<li><a href="newEvent.php">New Event</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
			<li id="profile">
				<a href="profile">Profile</a>
			</li>
			
		</ul>
	</div>
</div>

