<?php
	
	require_once('header.php');
	
	if(!isset($_GET["id"]) ){
		echo "404";
	}else if(!hasAccess($_GET["id"])){
			echo "404";
	}else{
		$result=getEvent($_GET["id"]);
		$posts=getAllPosts($_GET["id"]);?>

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
				<div class="form">
					<ul id="listUser">
						<?php
								$users=getUsers();
								//var_dump($users);
								foreach($users as $user){
									//echo "<li id=\"user".$user["idUser"]."\">"."<i class=\"fa fa-check\"></i>".$user["name"]."<i class=\"fa fa-plus\"></i>"."</li>";
								}
							?>

							<li id="user1" class="listUsers">
								<div id="goes">
									<i class="fa fa-check fa-lg"></i>
								</div>
								<div id="name">
									DIOGO
								</div>
								<div id="add">
									<i class="fa fa-minus fa-lg"></i>
								</div>
							</li>
							
							<li id="user1" class="listUsers">
								<div id="goes">
									<i class="fa fa-question fa-lg"></i>
								</div>
								<div id="name">
									Sergio
								</div>
								<div id="add">
									<i class="fa fa-plus fa-lg"></i>
								</div>
							</li>
					</ul>
				</div>
			</div>

			<?php } 
						
			require_once('footer.php');
			?>