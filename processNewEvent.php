<?php
session_start();
include_once('databaseConnection.php');
$target_dir = "static/event/".$_SESSION['userId'].'/';
if(!is_dir($target_dir)){
    mkdir($target_dir,0777,true);
}
$target_file = $target_dir . basename($_FILES["eventImage"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["eventImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
if ($_FILES["eventImage"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["eventImage"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$photoId=1;

if($uploadOk==1)
    $photoId=addPhoto(htmlspecialchars($target_file));

if (isset($_POST["nameEvent"],$_POST["description"],$_POST["creationDate"],$_POST["hour"],$_POST["endDate"],$_POST["local"],$_POST["type"],$_POST["public"])) {
	$nameEvent=$_POST["nameEvent"];
	$description=$_POST["description"];
	$creationDate=$_POST["creationDate"];
    $hour=$_POST["hour"];
	$endDate=$_POST["endDate"];
	$local=$_POST["local"];
	$type=$_POST["type"];
	$public=$_POST["public"];
	
	if($public=="public"){
		$public=true;
	}else{
		$public=false;
	}

	$newFormat_creationDate = date('Y-m-d', strtotime($creationDate));
	$newFormat_endDate = date('Y-m-d', strtotime($endDate));
    
	$id=createEvent($nameEvent,$description,$newFormat_creationDate,$hour,$newFormat_endDate,$local,$type,$public,$photoId, $_SESSION['userId']);
    
    header("Location:event.php?id=".$id);
}else{
    echo "error";
}
?>