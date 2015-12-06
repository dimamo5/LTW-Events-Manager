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
					<label id="newpost"><i class="fa fa-comment fa-2x"></i> New post<label>
				<?php }else if(goesEvent($_GET["id"],$_SESSION["userId"])){?>
					<label id="Users"><i class="fa fa-users fa-2x"></i> See User</label>
					<label id="seePhotos"><i class="fa fa-picture-o fa-2x"></i> See Photos</label>
					<label id="newpost"><i class="fa fa-comment fa-2x"></i><label>
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
	
	<div id="postSection">
		<div id="postHeader">
			<h3 id="cmt">Comment Section</h3>		
		</div>
		<?php 
		foreach ($posts as $post) {
			$user=getUser2($post['idUser']);
			$userPhoto=getPhoto($user['idPhoto']);
			$comments=getAllComments($post['idPost']);
		?>

		<div class="post">
			<div class="postHeader">
				<img id="profilePhoto" src="<?php echo $userPhoto['path'] ?>">
				<h2 id="user"><?php echo $user['name'] ?></h4>
			</div>
			<p id="info1"><?php echo $post['info'] ?></p>
			<?php 
				foreach ($comments as $comment) {
					$cmtUser=getUser($comment['idUser']);
					$userPhoto=getPhoto($cmtUser['idPhoto']);
			?>
				<div class="comment">
					<div class="commentHeader">
					<img id="profilePhoto" src="<?php echo $userPhoto['path'] ?>">
					<h4 id="user"><?php echo $cmtUser['name'] ?></h4>
					<p id="date"><?php echo $comment['creationDate']?></p>
					</div>
					<p id="info"><?php echo $comment['commentText'] ?></p>
					
				</div>
			<?php } ?>
			<div class="newCmt">
				<form action="addComment.php?id=askas" method="get">
					<input type="hidden" name="idEvent" value=<?php echo $_GET["id"]?> >
					<input type="hidden" name="idPost" value=<?php echo $post['idPost']?>>
					<input type="hidden" name="idUser" value=<?php echo $post['idUser']?>>
					<textarea id="commentText" name="comment" rows="3" cols="85" maxlength="250" placeholder="Add a comment...(max 250 characters)" required></textarea>						
					<button id="button" type="Submit" value="Send">Send</button>
				</form>
				
			</div>
		</div>
		<?php } ?>
	</div>

	<div id="NewPost" class="modalDialog">
	    <div class="form">
		    <form id="newPostForm" method="post">
		    <h2>New Post</h2>
			    <input id="newPost" name="postInfo" type="text" placeholder="Add a Post..." required >
			    <div id="selectOption">
				    <button id="post" type="submit">Save</button>
				    <button id="back">Cancel</button>
			    
			    </div>
		    </form>
	    </div>
    </div>


	<?php  
	 } 
						
	include_once('footer.php');
?>