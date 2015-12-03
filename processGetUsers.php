<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["username"],$_POST["eventId"])) {
	$name=htmlspecialchars($_POST["username"]);
	$eventId=htmlspecialchars($_POST["eventId"]);
    
    if (isAdmin($eventId, $_SESSION['userId'])) {
       $notInvited=getUserEventName($name,$eventId);
	   $invited=getUsersEvent($eventId);
	   $data=['invited'=>$invited,
	   			'notinvited'=>$notInvited];
		echo json_encode($data);
	   
} else {
   echo json_encode(["getuser"=>"failed"]);
}
}
else {
   echo json_encode(["getUser"=>"failed"]);
}
?>