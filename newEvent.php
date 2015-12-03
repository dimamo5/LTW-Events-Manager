<?php
	
	require_once('header.php');
	?>

	<div id="newEventContainer">

		<form class="form" action="processNewEvent.php" id="newEvent" method="POST" enctype="multipart/form-data">
			<h2>New Event</h2>
			<input id="nameEvent" name="nameEvent" type="text" placeholder="Name" required="" autofocus="">
			<input id="description" name="description" type="text" placeholder="Description" required="">
			<input id="creationDate" name="creationDate" type="date" placeholder="Start Date" required="">
			<input id="endDate" name="endDate" type="date" placeholder="End Date" required="">
			<input id="local" name="local" type="text" placeholder="Place" required="">
			<input id="type" name="type" type="text" placeholder="Type" required="">
			<div id="choosePublic">
			<label id="publicLabel">Public</label>
			<input id="publicRadio" name="public" type="radio" value="public" required="" checked>	
			<label id="privateLabel">Private</label>
			<input id="privateRadio" name="public" type="radio" value="private" required="">
			</div>
			<input type="file" name="eventImage" id="eventImage">
			
			<button id="create" type="submit">Create</button>

		</form>
	</div>

	<?php ?>