<?php
include_once '../databaseConnection.php';
session_start();
if (isset($_POST["username"], $_POST["password"],$_POST["email"],$_POST["name"],$_POST["birthday"])) {
	
	$username=$_POST["username"];
	$email=$_POST["email"];
	$password=$_POST["password"];
	$name=$_POST["name"];
  	$birthday=$_POST["birthday"];
	$name=$_POST["name"];
	
	$result=register($username,$password,$email,$name,$birthday);
	
	$data = ["register" => $result];
	echo json_encode($data);
}
?>