<?php
	require 'header.php' ;

	if(!isset($_GET["search_text"])){	
		echo "Enter a search term in the box above.";		
	}
	else if( strlen($_GET["search_text"]) == 0){
		echo "Enter a search term in the box above.";
	}
	else{
		$results=getEventSearch($_GET["search_text"]);
				
		foreach($results as $result) { ?>
		<div class="card"  id="event<?php echo $result["idEvent"]?>"  >
			<h1><?php echo $result['nameEvent'] ?></h1>
			<div class="desc">
				<div class="descText">
					<p><?php echo $result['description'] ?></p>
					<p><?php echo $result['creationDate']." ".$result['endDate']." ".$result['local'] ?></p>
				</div>
				<div class="imgContainer">
					<img src="static/user/userDefault.png"/>
				</div>
			</div>
		</div>
	<
			<?php 
			}
		}

	require 'footer.php';
 ?>