<?php 
	require 'header.php';
	
	$result = getUser($_SESSION['userId']);
	
	$imagepath = getUserImagePath($_SESSION['userId']);	
?>

<div class="User">

	<div class="UserImage">
		<img src= <?php echo $imagepath ?> style="width:256px;height:148px;">
	</div>
	
	<div class="UserInfo">
		<ul class="InfoList">
		<li><h1><?php echo $result['name']?> </h1></li>
		<li><h3><?php echo $result['birthday']?> </h3></li>
		<li><h3><?php echo $result['email']?> </h3></li>
		</ul>
	</div>

</div>


<?php 
	require 'footer.php';
?>