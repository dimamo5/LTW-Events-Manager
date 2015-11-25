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
    
    <link rel="stylesheet" type="text/css" href="css/eventManager.css">
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/eventManager.js"></script>


</head>

<body>
<div id="hmenu">
<ul>
	<img id="logo" src="static/website/logo.png"></img>
	<div id="containerNavBar">
  <form id="searchbox" action="">
    <input id="search" type="text" placeholder="Type here">
    <input id="submit" type="submit" value="Search">
</form>
  <li><a href="news.asp">News</a></li>
  <li><a href="contact.asp">Contact</a></li>
  <li><a href="logout.php">Logout</a></li>
  </div>
</ul>
</div>


<?php
    $results = getMyEvents();
	foreach($results as $result) { ?>
		<div class="card"  id="event<?php echo $result["idEvent"]?>"  >
			<h1><?php echo $result['nameEvent'] ?></h1>
			<div class="desc">
				<div class="descText">
					<p><?php echo $result['description'] ?></p>
					<p><?php echo $result['creationDate']." ".$result['endDate']." ".$result['local'] ?></p>
				</div>
				<div class="imgContainer">
					<img src="static/user/userDefault.png"/>
				</div>
			</div>
		</div>
	<?php } ?>

?>

</body>
</html>