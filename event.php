	<?php
	
	include_once('header.php');
	include_once('utils.php');
	
	if(!isset($_GET["id"]) ){
		displayError();
	}else if(!hasAccess($_GET["id"]) && !isPublic($_GET["id"])){
			displayError();
	}else{
		$result=getEvent($_GET["id"]);
		$posts=getAllPosts($_GET["id"]);
		
		getEventPageCard($result);
		?>

		<div class="options">
				<?php if(isAdmin($_GET["id"],$_SESSION["userId"])){?>
					<label id="addUser"><i class="fa fa-users fa-2x"></i> Edit User</label>
					<label id="editEvent"><i class="fa fa-pencil fa-2x"></i> Edit Event</label>
					<label id="deleteEvent"><i class="fa fa-trash fa-2x"></i> Delete Event</label>
					<label id="addPhoto"><i class="fa fa-camera fa-2x"></i> Add Photo</label>
					<label id="seePhotos"><i class="fa fa-picture-o fa-2x"></i> See Photos</label>
					<label id="newpost"><i class="fa fa-comment fa-2x"></i> New post</label>
				<?php }else if(goesEvent($_GET["id"],$_SESSION["userId"])){?>
					<label id="Users"><i class="fa fa-users fa-2x"></i> See User</label>
					<label id="seePhotos"><i class="fa fa-picture-o fa-2x"></i> See Photos</label>
					<label id="newpost"><i class="fa fa-comment fa-2x"></i></label>
				<?php }else if(hasAccess($_GET["id"])){?>
					<label id="accept"><i class="fa fa-check fa-2x"></i> Accept</label>
					<label id="decline"><i class="fa fa-times fa-2x"></i> Decline</label>
				<?php }else if(isPublic($_GET["id"])){?>
					<label id="autoInvite"><i class="fa fa-check fa-2x"></i> Want to go</label>
				<?php } ?>
				
			</div>
		</div>		
	</div>

	<?php

	if(isAdmin($_GET["id"],$_SESSION["userId"])){
		editEventModal($result);
		inviteUserModal($_GET["id"]);
		addPhotoModal($_GET["id"]);
		viewPhotos($_GET["id"]);
		addNewPostModal();
	 }else if(goesEvent($_GET["id"],$_SESSION["userId"])){
		listUsersModal($_GET["id"]);
		viewPhotos($_GET["id"]);
		addNewPostModal();
	} ?>
	
	<?php if(goesEvent($_GET["id"],$_SESSION["userId"])){
			addPostSection($posts);
	 } 
	 	}
						
	include_once('footer.php');
?>