
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
				<div class="CardInfo">
						<div class="name">
					<h1><?php echo $adminEvent['nameEvent']?></h1> <?php if($adminEvent["public"]){echo "<i class=\"fa fa-unlock fa-2x\"></i>";}else{echo "<i class=\"fa fa-lock fa-2x\"></i>";}?>
				</div>
			<div>
				<p>
					<?php echo $adminEvent['description'] ?>
				</p>
				<p>
					<i class="fa fa-calendar fa-lg"></i> <?php echo $adminEvent['creationDate']." ".$adminEvent["hour"]."  <i class=\"fa fa-arrow-right fa-lg\"></i>  ".$adminEvent['endDate'] ?>
				</p>
				<p>
					<i class="fa fa-map-marker fa-lg"></i> <?php echo $adminEvent['local'];?>
				</p>
				<p>
					<i class="fa fa-flag"></i> <?php echo $adminEvent['type'];?>
				</p>
			</div>
				</div>
				<div class="imgContainer">
						<img src="<?php echo $adminEvent['path'];?>"/>
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
				<div class="CardInfo">
						<div class="name">
					<h1><?php echo $invitedEvent['nameEvent']?></h1> <?php if($invitedEvent["public"]){echo "<i class=\"fa fa-unlock fa-2x\"></i>";}else{echo "<i class=\"fa fa-lock fa-2x\"></i>";}?>
					<span class="statusInvite"><?php if($invitedEvent["confirm"]==0){echo"<i class=\"fa fa-question fa-2x\"></i>To Respond";}else if($invitedEvent["confirm"]==1){echo"<i class=\"fa fa-check fa-2x\"></i>Going";}
					else if($invitedEvent["confirm"]==-1){echo"<i class=\"fa fa-times fa-2x\"></i>Not Going";}?></span>
				</div>
			<div>
				<p>
					<?php echo $invitedEvent['description'] ?>
				</p>
				<p>
					<i class="fa fa-calendar fa-lg"></i> <?php echo $invitedEvent['creationDate']." ".$invitedEvent["hour"]."  <i class=\"fa fa-arrow-right fa-lg\"></i>  ".$invitedEvent['endDate'] ?>
				</p>
				<p>
					<i class="fa fa-map-marker fa-lg"></i> <?php echo $invitedEvent['local'];?>
				</p>
				<p>
					<i class="fa fa-flag"></i> <?php echo $invitedEvent['type'];?>
				</p>
			</div>
				</div>
				<div class="imgContainer">
						<img src="<?php echo $invitedEvent['path'];?>" />
				</div>
			</div>			
				
		<?php } 
	}
	
	
	require_once('footer.php');
?>

