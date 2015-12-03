<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["idUser"],$_POST["type"],$_POST["eventId"])) {
	$idUser=htmlspecialchars($_POST["idUser"]);
	$type=htmlspecialchars($_POST["type"]);
	$eventId=htmlspecialchars($_POST["eventId"]);
	
	if($type=="add"){
		if(addUser($eventId,$idUser)){
			echo json_encode(["editUser"=>"success"]);
		}else{
			echo json_encode(["editUser"=>"failed"]);
		}
	}else if($type=="sub"){
		if(removeUser($eventId,$idUser)){
			echo json_encode(["editUser"=>"success"]);
		}else{
			echo json_encode(["editUser"=>"failed"]);
		}
	}
}    
else {
   echo json_encode(["editUser"=>"failed"]);
}
?>