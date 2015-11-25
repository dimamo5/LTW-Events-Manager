<?php ob_start();
include_once 'databaseConnection.php';
session_start();

if (isset($_POST["username"], $_POST["password"],$_POST["email"],$_POST["name"],$_POST["birthday"])) {
	
	$username=$_POST["username"];
	$email=$_POST["email"];
	$password=$_POST["password"];
	
    $db = $db = new PDO('sqlite:event.db');
    $queryUsername = "SELECT * FROM User WHERE loginId='";
    $queryUsername .= $username . "';";
	
	$stmt = $db->prepare($queryUsername);
	$stmt->execute();
	$result = $stmt->fetchAll();
	
	if(count($result)!=0){
		$data = ["login" => "invalid_username"];
		echo json_encode($data);
		return;
    }
	
    $queryEmail = "SELECT * FROM User WHERE email='";
    $queryEmail .= $email . "';";
	
	$stmt = $db->prepare($queryEmail);
	$stmt->execute();
	$result = $stmt->fetchAll();
	
    if(count($result)!=0){
        $data = ["login" => "invalid_email"];
		echo json_encode($data);
		return;
    }
	
	$stmt =$db->prepare("INSERT INTO User(loginId,password,email,name,birthday,idPhoto) VALUES (:username,:password,:email,:name,:birthday,1))");
    $mtmt->bindParam(':username',$username,PDO::PARAM_INT);
	$mtmt->bindParam(':password',$_POST["password"],PDO::PARAM_INT);
	$mtmt->bindParam(':email',$_POST["email"],PDO::PARAM_INT);
	$mtmt->bindParam(':name',$_POST["name"],PDO::PARAM_INT);
	$mtmt->bindParam(':birthday',$_POST["birthday"],PDO::PARAM_INT);
	if($stmt->execute()!=1){
		$data = ["login" => "error"];
		echo json_encode($data);
		return;
	}else{
		login($username,$password);
		$data = ["login" => "success"];
		echo json_encode($data);
		return;
	}
}else{
		$data = ["login" => "error"];
		echo json_encode($data);
		return;
}
ob_end_flush();
?>