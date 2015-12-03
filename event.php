<?php
	
	require_once('header.php');
	
	if(!isset($_GET["id"]) ){
		echo "404";
	}else if(!hasAccess($_GET["id"])){
			echo "404";
	}else{
		$result=getEvent($_GET["id"]);?>

	<div class="cardEventPage" id="event<?php echo $result['idEvent']?>">
		<div class="imgContainerPage">
			<img src="static/user/userDefault.png" />
		</div>
		<div class="eventInfo">
			<div class="eventInfoContent">
				<div class="name">
					<h1><?php echo $result['nameEvent']?></h1> <?php if($result["public"]){echo "<i class=\"fa fa-unlock fa-lg\"></i>";}else{echo "<i class=\"fa fa-lock fa-lg\"></i>";}?>
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
				<label id="addUser"><i class="fa fa-users fa-2x"></i> Edit User</label>
				<label id="editEvent"><i class="fa fa-pencil fa-2x"></i> Edit Event</label>
				<label id="deleteEvent"><i class="fa fa-trash fa-2x"></i> Delete Event</label>

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

	<?php } 
						
			require_once('footer.php');
			?>