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

		<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

		<script src="js/sweetalert.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="js/eventManager.js"></script>


	</head>

	<body>
		<div id="hmenu">
			<div id="containerNavBar">

				<ul class="nav">
					<a href="index.php"><img id="logo" src="static/website/logo.png"></img>
					</a>
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
							<li><a href="#">Board</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
					<li id="profile">
						<a href="profile">Profile</a>
					</li>

				</ul>
			</div>
		</div>

		<?php
	if(!isset($_GET["id"]) ){
		echo "404";
	}else if(!hasAccess($_GET["id"])){
			echo "404";
	}else{
		$result=getEvent($_GET["id"]);?>

			<div class="cardEvent" id="event<?php echo $result['idEvent']?>">
				<div id="contNameOptions">
					<h1><?php echo $result['nameEvent'] ?></h1>
					<div id="options">
						<i id="addUser" class="fa fa-plus fa-2x"></i>
						<i id="editEvent" class="fa fa-pencil fa-2x"></i>
						<i id="deleteEvent" class="fa fa-trash fa-2x"></i>

					</div>
				</div>
				<div class="desc">
					<div class="descText">
						<p>
							<?php echo $result['description'] ?>
						</p>
						<p>
							<?php echo $result['creationDate']." ".$result['endDate']." ".$result['local'] ?>
						</p>
					</div>
					<div class="imgContainer">
						<img src="static/user/userDefault.png" />
					</div>
				</div>
			</div>
			<?php } ?>

				<div id="openModal" class="modalDialog">
					<div>
						<form id="editEvent" method="post">
							<h2>Edit Event</h2>
							<input id="nameEvent" name="nameEvent" type="text" value="<?php echo $result[ "nameEvent"]?>" required="" autofocus="">
							<input id="description" name="description" type="text" value="<?php echo $result[ "description"]?>" required="">
							<input id="creationDate" name="creationDate" type="date" value="<?php echo $result[ "creationDate"]?>" required="">
							<input id="endDate" name="endDate" type="date" value="<?php echo $result[ "endDate"]?>" required="">
							<input id="local" name="local" type="text" value="<?php echo $result[ "local"]?>" required="">
							<input id="type" name="type" type="text" value="<?php echo $result[ "type"]?>" required="">
							<div id="selectOption">
								<button id="save" type="submit">Save</button>
								<button id="cancel">Cancel</button>
								
							</div>
						</form>
					</div>
				</div>

	</body>

	</html>