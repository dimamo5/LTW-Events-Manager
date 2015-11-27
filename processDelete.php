<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["eventId"])) {

    $userId = $_SESSION["userId"];
	$eventId=$_POST["eventId"];
   
    if (isAdmin($eventId, $userId)) {
       if(deleteEvent($eventId)){
		   echo json_encode(["delete"=>"success"]);
	   }
	   else{
		   echo json_encode(["delete"=>"failed"]);
	   }
    }else{
        echo json_encode(["delete"=>"failed"]);
    }
} else {
   echo json_encode(["delete"=>"failed"]);
}
?>