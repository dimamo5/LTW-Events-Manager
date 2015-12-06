<?php
session_start();
include_once('../databaseConnection.php');

if (isset($_POST["idEvent"],$_POST["info"])) {
	$eventId=htmlspecialchars($_POST["idEvent"]);
	$info=htmlspecialchars($_POST["info"]);
    
    if (isAdmin($eventId, $_SESSION['userId'])) {
       if(addPost($eventId,$info)){
		   echo json_encode(["edit"=>"success"]);
	   }
	   else{
		   echo json_encode(["edit"=>"failed"]);
	   }
    }else{
        echo json_encode(["edit"=>"failed"]);
    }
} else {
   echo json_encode(["edit"=>"failed"]);
}
?>