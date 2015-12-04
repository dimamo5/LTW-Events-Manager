<?php
	
	require_once('header.php');
	
	if(!isset($_GET["id"]) ){
		echo "404";
	}else if(!hasAccess($_GET["id"]) && !isPublic($_GET["id"])){
			echo "404";
	}else{
		$result=getEvent($_GET["id"]);
		$posts=getAllPosts($_GET["id"]);?>

	<div class="cardEventPage" id="event<?php echo $result['idEvent']?>">
		<div class="imgContainerPage">
			<img src=<?php echo $result["path"]?> />
		</div>
		<div class="eventInfo">
			<div class="eventInfoContent">
				<div class="name">
					<h1><?php echo $result['nameEvent']?></h1> <?php if($result["public"]){echo "<i class=\"fa fa-unlock fa-2x\"></i>";}else{echo "<i class=\"fa fa-lock fa-2x\"></i>";}?>
				</div>
			<div>
				<p>
					<?php echo $result['description'] ?>
				</p>
				<p>
					<i class="fa fa-calendar fa-lg"></i> <?php echo $result['creationDate']." ".$result["hour"]."  <i class=\"fa fa-arrow-right fa-lg\"></i>  ".$result['endDate'] ?>
				</p>
				<p>
					<i class="fa fa-map-marker fa-lg"></i> <?php echo $result['local'];?>
				</p>
			</div>
		</div>

		<div class="options">
				<?php if(isAdmin($_GET["id"],$_SESSION["userId"])){?>
					<label id="addUser"><i class="fa fa-users fa-2x"></i> Edit User</label>
					<label id="editEvent"><i class="fa fa-pencil fa-2x"></i> Edit Event</label>
					<label id="deleteEvent"><i class="fa fa-trash fa-2x"></i> Delete Event</label>
				<?php }else if(goesEvent($_GET["id"],$_SESSION["userId"])){?>
					<label id="Users"><i class="fa fa-users fa-2x"></i> See User</label>
				<?php }else if(hasAccess($_GET["id"])){?>
					<label id="accept"><i class="fa fa-check fa-2x"></i> Accept</label>
					<label id="decline"><i class="fa fa-times fa-2x"></i> Decline</label>
				<?php }else if(isPublic($_GET["id"])){?>
					<label id="autoInvite"><i class="fa fa-check fa-2x"></i> Want to go</label>
				<?php } ?>
				

			</div>
		</div>
		
	</div>


	<div id="openModal" class="modalDialog">
		<div class="form">
			<form id="editEvent" method="post">
				<h2>Edit Event</h2>
				<input id="nameEvent" name="nameEvent" type="text" value="<?php echo $result["nameEvent"]?>" required="" autofocus="">
				<input id="description" name="description" type="text" value="<?php echo $result["description"]?>" required="">
				<input id="creationDate" name="creationDate" type="date" value="<?php echo $result["creationDate"]?>" required="">
				<input id="endDate" name="endDate" type="date" value="<?php echo $result["endDate"]?>" required="">
				<input id="local" name="local" type="text" value="<?php echo $result["local"]?>" required="">
				<input id="type" name="type" type="text" value="<?php echo $result["type"]?>" required="">
				<div id="selectOption">
					<button id="save" type="submit">Save</button>
					<button id="cancel">Cancel</button>

				</div>
			</form>
		</div>
	</div>

	<div id="inviteUser" class="modalDialog">
		<div id="inviteUserModal" class="form">
			<form id="inviteUserForm">
				<input type="text" name="search_text" id="searchUser" placeholder="Search" />
			</form>

			<ul id="listUser">
				<?php
								$users=getUsersEvent($_GET['id']);
								foreach($users as $user){?>
					<li id="user<?php echo $user['idUser']?>" class="listUsers">
						<div id="name"><?php echo $user['name']?></div>
						<div id="sub">
							<i class="fa fa-minus fa-lg"></i>
						</div>
					</li>

					<?php }?>

			</ul>
		</div>
	</div>
	
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
						
			require_once('footer.php');
			?>