<?php
	
	include_once('header.php');
	include_once('utils.php');
	
	if(!isset($_GET["id"]) ){
		echo "404";
	}else if(!hasAccess($_GET["id"]) && !isPublic($_GET["id"])){
			echo "404";
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
				<?php }else if(goesEvent($_GET["id"],$_SESSION["userId"])){?>
					<label id="Users"><i class="fa fa-users fa-2x"></i> See User</label>
					<label id="seePhotos"><i class="fa fa-picture-o fa-2x"></i> See Photos</label>
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
	 }else if(goesEvent($_GET["id"],$_SESSION["userId"])){
		listUsersModal($_GET["id"]);
		viewPhotos($_GET["id"]);
	} ?>
	
	<?php 
			foreach ($posts as $post) {
				$user=getUser2($post['idUser']);
				$comments=getAllComments($post['idPost']);
			?>

			<div class="cardEvent" id="post">
				<h4 id="user"><?php echo $user['name'] ?></h4>
				<p id="info"><?php echo $post['info'] ?></p>
				<?php 
					foreach ($comments as $comment) {
						$cmtUser=getUser2($comment['idUser']);
				?>
					<div class="cardEvent" id="comment">
						<h4 id="user"><?php echo $cmtUser['name'] ?></h4>
						<p id="info"><?php echo $comment['commentText'] ?></p>
						<p id="date"><?php echo $comment['creationDate']?></p>
					</div>
				<?php } ?>
				<div class="cardEvent" id="newCmt">
					<form action="addComment.php?id=askas" method="get">
						<input type="hidden" name="idEvent" value=<?php echo $_GET["id"]?> >
						<input type="hidden" name="idPost" value=<?php echo $post['idPost']?>>
						<input type="hidden" name="idUser" value=<?php echo $post['idUser']?>>
						<textarea id="commentText" name="comment" rows="3" cols="85"></textarea>						
						<button id="button" type="Submit" value="Send">Send</button>
					</form>
					
				</div>
			</div>
			<?php } ?>
	<?php } 
						
			include_once('footer.php');
			?>