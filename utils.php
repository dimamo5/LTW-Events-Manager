<?php
function getEventCard($event,$confirm){
    ?>
    
    <div class="card" id="event<?php echo $event['idEvent'];?>">
    <div class="CardInfo">
    <div class="name">
    <h1><?php echo $event['nameEvent'];?></h1>
    <?php if($event["public"]){echo "<i class=\"fa fa-unlock fa-2x\"></i>";}else{echo "<i class=\"fa fa-lock fa-2x\"></i>";}?>
    <?php if($confirm){
        ?><span class="statusInvite"><?php if($event["confirm"]==0){echo"<i class=\"fa fa-question fa-2x\"></i>To Respond";}
        else if($event["confirm"]==1){echo"<i class=\"fa fa-check fa-2x\"></i>Going";}
        else if($event["confirm"]==-1){echo"<i class=\"fa fa-times fa-2x\"></i>Not Going";}?></span>
    <?php } ?>
    </div>
    <div>
    <p>
    <?php echo $event['description']; ?>
    </p>
    <p>
    <i class="fa fa-calendar fa-lg"></i>
    <?php echo $event['creationDate']."  ".$event["hour"]."  <i class=\"fa fa-arrow-right fa-lg\"></i>  ".$event['endDate']; ?>
    </p>
    <p>
    <i class="fa fa-map-marker fa-lg"></i>
    <?php echo $event['local'];?>
    </p>
    <p>
    <i class="fa fa-flag"></i>
    <?php echo $event['type'];?>
    </p>
    </div>
    </div>
    <div class="imgContainer">
    <img src="<?php echo $event['path'];?>" />
    </div>
    </div>
<?php } ?>

<?php
function getEventPageCard($event){
    ?>
    <div class="cardEventPage" id="event<?php echo $event['idEvent']?>">
    <div class="imgContainerPage">
    <img src="<?php echo $event["path"]?>" />
    </div>
    <div class="eventInfo">
    <div class="eventInfoContent">
    <div class="name">
    <h1><?php echo $event['nameEvent']?></h1> <?php if($event["public"]){echo "<i class=\"fa fa-unlock fa-2x\"></i>";}else{echo "<i class=\"fa fa-lock fa-2x\"></i>";}?>
    </div>
    <div>
    <p>
    <?php echo $event['description'] ?>
    </p>
    <p>
    <i class="fa fa-calendar fa-lg"></i> <?php echo $event['creationDate']." ".$event["hour"]."  <i class=\"fa fa-arrow-right fa-lg\"></i>  ".$event['endDate'] ?>
    </p>
    <p>
    <i class="fa fa-map-marker fa-lg"></i> <?php echo $event['local'];?>
    </p>
    <p>
    <i class="fa fa-flag"></i>
    <?php echo $event['type'];?>
    </p>
    </div>
    </div>
<?php } ?>

<?php
function editEventModal($event){
    ?>
    <div id="openModal" class="modalDialog">
    <div class="form">
    <form id="editEvent" method="post">
    <h2>Edit Event</h2>
    <input id="nameEvent" name="nameEvent" type="text" value="<?php echo $event["nameEvent"]?>" required="" autofocus="">
    <input id="description" name="description" type="text" value="<?php echo $event["description"]?>" required="">
    <input id="creationDate" name="creationDate" type="date" value="<?php echo $event["creationDate"]?>" required="">
    <input id="endDate" name="endDate" type="date" value="<?php echo $event["endDate"]?>" required="">
    <input id="hour" name="hour" type="hour" value="<?php echo $event["hour"]?>" required="">
    <input id="local" name="local" type="text" value="<?php echo $event["local"]?>" required="">
    <input id="type" name="type" type="text" value="<?php echo $event["type"]?>" required="">
    <div id="selectOption">
    <button id="save" type="submit">Save</button>
    <button id="cancel">Cancel</button>
    
    </div>
    </form>
    </div>
    </div>
<?php } ?>

<?php
function inviteUserModal($eventid){
    ?>
    <div id="inviteUser" class="modalDialog">
    <div id="inviteUserModal" class="form">
    <form id="inviteUserForm">
    <input type="text" name="search_text" id="searchUser" placeholder="Search" />
    </form>
    
    <ul id="listUser">
    <?php
    $users=getUsersEvent($eventid);
    foreach($users as $user){?>
        <li id="user<?php echo $user['idUser']?>" class="listUsers">
        <div id="name"><?php echo $user['name']?></div>
        <div id="sub">
        <i class="fa fa-minus fa-lg"></i>
        </div>
        </li>
        
    <?php } ?>
    
    </ul>
    </div>
    </div>
<?php } ?>

<?php
function listUsersModal($eventid){ ?>
    
    <div id="listUsers" class="modalDialog">
    <div class="form">
    <h2>List of Invites</h2>
    <ul id="listUser">
    <?php
    $users=getUsersEvent($eventid);
    foreach($users as $user){?>
        <li id="user<?php echo $user['idUser']?>" class="listUsers">
        <div id="name"><?php echo $user['name']?></div>
        <?php if($user["confirm"]==0){echo"<i class=\"fa fa-question fa-2x\"></i>To Respond";}else if($user["confirm"]==1){echo"<i class=\"fa fa-check fa-2x\"></i>Going";}
        else if($user["confirm"]==-1){echo"<i class=\"fa fa-times fa-2x\"></i>Not Going";}?></span>
        </li>
        
    <?php } ?>
    </ul>
    </div>
    </div>
<?php } ?>

<?php
function addPhotoModal($event){
    ?>
    <div id="addPhotoModal" class="modalDialog">
    <div class="form">
    <form id="addPhotoForm" method="post" enctype="multipart/form-data">
    <h2>Add Photo</h2>
    <input type="file" name="eventPhoto" id="eventPhoto" accept="image" multiple>
    <button type="submit">Submit</button>
    </form>
    </div>
    
    </div>
<?php } ?>

<?php
function viewPhotos($event){ 
    $photos=getPhotoPath($event);
    $size=count($photos);
    $coluns=ceil($size/3);
    $counter=0;
    ?>
    
    <div id="viewPhotos" class="modalDialog">
    <div class="form">
    <?php if(count($photos)==0){?>
    <div class="errorNoPhoto">
       <i class="fa fa-exclamation-triangle fa-2x"></i> <h2>No photos</h2>
    </div>
   <?php } ?>
   <table class="gridtable">
  <?php for($i=0;$i<$coluns;$i++){
      echo "<tr>";
        for($j=0;$j<3;$j++){
            
            echo "<td>";
            if($counter<$size)
            echo "<img src=\"".$photos[$counter]["path"]."\">";
            echo "</td>";
            $counter++;
        }     
      
      echo "</tr>";
  }
  
  
  ?>
</table>
    <button id="close">Close</button>
    </div>
    </div>
<?php } ?>

<?php function displayError(){
    ?>
    <div class="error">
       <i class="fa fa-exclamation-triangle fa-2x"></i> <h2>This page can not be displayed!</h2>
    </div>
<?php } ?> 

<?php function displaySearchError(){
    ?>
    <div class="error">
       <i class="fa fa-exclamation-triangle fa-2x"></i> <h2>No results found!</h2>
    </div>
<?php } ?> 

<?php
function addNewPostModal(){
    ?>
    	<div id="NewPost" class="modalDialog">
	    <div class="form">
		    <form id="newPostForm" method="post" novalidate>
		    <h2>New Post</h2>
			    <input id="newPost" name="postInfo" type="text" placeholder="Add a Post..." required >
			    <div id="selectOption">
				    <button id="post" type="submit">Save</button>
				    <button id="back">Cancel</button>
			    
			    </div>
		    </form>
	    </div>
    </div>
<?php } ?>

<?php
function addPostSection($posts){ ?>
    <div id="postSection">
		<div id="postHeader">
			<h3 id="cmt">Comment Section</h3>		
		</div>
		<?php 
		foreach ($posts as $post) {
			$user=getUser($post['idUser']);
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
<?php } ?>