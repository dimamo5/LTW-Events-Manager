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

    <title>Event Manager</title>
	
	<link rel="shortcut icon" href="static/website/logo.png">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/eventManager.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/eventManager.js"></script>


</head>
<body>
	<div id="hmenu">
		<div id="containerNavBar">

			<ul class="nav">
				<a href="index.php"><img id="logo" src="static/website/logo.png"></img>
				</a>
				<li id="search">
					<form action="eventSearchPage.php" method="get">
						<input type="text" name="search_text" id="search_text" placeholder="Search" />
						<button type="submit" name="search_button" id="search_button"><i class="fa fa-search"></i></button>
					</form>
				</li>
				<li id="options">
					<a href="#">Options  <i class="fa fa-arrow-down"></i></a>
					<ul class="subnav">
						<li><a href="newEvent.php">New Event</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
				<li id="profile">
					<div class="profileButton">
						<div class ="profileButtonImage">
							<img src= <?php echo getUserImagePath($_SESSION['userId']); ?> style="width:50px;height:50px;">	
						</div>
						<div class="profileButtonText">
							<a href="profile.php"> <?php echo getUser($_SESSION['userId'])['name'] ?> </a>
						</div>						
					</div>
				</li>			
			</ul>
		</div>
	</div>
	<div class="wrapper">