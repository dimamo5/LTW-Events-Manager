<?php
session_start();
include_once('databaseConnection.php');

if (isset($_POST["idEvent"],$_POST["nameEvent"],$_POST["description"],$_POST["creationDate"],$_POST["endDate"],$_POST["local"],$_POST["type"])) {
	$eventId=$_POST["idEvent"];
	$description=$_POST["nameEvent"];
	$nameEvent=$_POST["description"];
	$creationDate=$_POST["creationDate"];
	$endDate=$_POST["endDate"];
	$local=$_POST["local"];
	$type=$_POST["type"];
    
       if(editEvent($eventId,$description,$nameEvent,$creationDate,$endDate,$local,$type, $_SESSION['userId'])){
		   echo json_encode(["create"=>"success"]);
	   }
	   else{
		   echo json_encode(["create"=>"failed"]);
	   }
} else {
   echo json_encode(["create"=>"failed"]);
}
?>