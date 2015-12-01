
<?php
	require_once('header.php');

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
	<?php } 
	
	
	require_once('footer.php');
	?>

