
<?php
	require_once('header.php');

    $invitedEvents = getEventsInvited();
	$adminEvents = getEvensAdmin();
	
	if(count($adminEvents) > 0){
		?>
		<div class="spacer">
			<h1> Events that I manage: </h1>
		</div>
		
		<?php 
			foreach($adminEvents as $adminEvent){
				?>
			<div class="card"  id="event<?php echo $adminEvent["idEvent"]?>"  >
				<h1><?php echo $adminEvent['nameEvent'] ?></h1>
				<div class="desc">
					<div class="descText">
						<p><?php echo $adminEvent['description'] ?></p>
						<p><?php echo $adminEvent['creationDate']." ".$adminEvent['endDate']." ".$adminEvent['local'] ?></p>
					</div>
					<div class="imgContainer">
						<img src="static/user/userDefault.png"/>
					</div>
				</div>
			</div>				
				
		<?php } 
		} 		
	
	if(count($invitedEvents) > 0){
		?>
		<div class="spacer">
			<h1> Invited to: </h1>
		</div>
		<?php 
			foreach($invitedEvents as $invitedEvent){
				?>
			<div class="card"  id="event<?php echo $invitedEvent["idEvent"]?>"  >
				<h1><?php echo $invitedEvent['nameEvent'] ?></h1>
				<div class="desc">
					<div class="descText">
						<p><?php echo $invitedEvent['description'] ?></p>
						<p><?php echo $invitedEvent['creationDate']." ".$invitedEvent['endDate']." ".$invitedEvent['local'] ?></p>
					</div>
					<div class="imgContainer">
						<img src="static/user/userDefault.png"/>
					</div>
				</div>
			</div>				
				
		<?php } 
	}
	
	
	require_once('footer.php');
?>

