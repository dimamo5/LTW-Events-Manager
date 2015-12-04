<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["idEvent"],$_POST["request"])) {
	$idUser=$_SESSION["userId"];
	$idEvent=htmlspecialchars($_POST["idEvent"]);
	$response=htmlspecialchars($_POST["request"]);
	
	if($response=="accept"){
		if(acceptInvite($idEvent,$idUser)){
			echo json_encode(["invite"=>"success"]);
		}else{
			echo json_encode(["invite"=>"failed"]);
		}
	}else if($response=="decline"){
		if(declineInvite($idEvent,$idUser)){
			echo json_encode(["invite"=>"success"]);
		}else{
			echo json_encode(["invite"=>"failed"]);
		}
	}else if($response=="entry"){
		if(autoInvite($idEvent,$idUser)){
			echo json_encode(["invite"=>"success"]);
		}else{
			echo json_encode(["invite"=>"failed"]);
		}
	}
}    
else {
   echo json_encode(["invite"=>"failed"]);
}
?>