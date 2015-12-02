<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["idEvent"],$_POST["nameEvent"],$_POST["description"],$_POST["creationDate"],$_POST["endDate"],$_POST["local"],$_POST["type"])) {
	$eventId=htmlspecialchars($_POST["idEvent"]);
	$nameEvent=htmlspecialchars($_POST["nameEvent"]);
	$description=htmlspecialchars($_POST["description"]);
	$creationDate=htmlspecialchars($_POST["creationDate"]);
	$endDate=htmlspecialchars($_POST["endDate"]);
	$local=htmlspecialchars($_POST["local"]);
	$type=htmlspecialchars($_POST["type"]);
    
    if (isAdmin($eventId, $_SESSION['userId'])) {
       if(editEvent($eventId,$description,$nameEvent,$creationDate,$endDate,$local,$type)){
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