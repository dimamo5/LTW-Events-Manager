<?php
session_start();
include_once('databaseConnection.php');

var_dump($_FILES);
die();

$target_dir = "static/events";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if ($_FILES["fileToUpload"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}






if (isset($_POST["nameEvent"],$_POST["description"],$_POST["creationDate"],$_POST["endDate"],$_POST["local"],$_POST["type"],$_POST["public"])) {
	$description=$_POST["nameEvent"];
	$nameEvent=$_POST["description"];
	$creationDate=$_POST["creationDate"];
	$endDate=$_POST["endDate"];
	$local=$_POST["local"];
	$type=$_POST["type"];
	$public=$_POST["public"];
	
	if($public=="public"){
		$public=true;
	}else{
		$public=false;
	}
    
	$id=createEvent($description,$nameEvent,$creationDate,$endDate,$local,$type,$public, $_SESSION['userId']);
	
       if($id>0){
		   echo json_encode(["create"=>$id]);
	   }
	   else{
		   echo json_encode(["create"=>"failed"]);
	   }
} else {
   echo json_encode(["create"=>"failessadasdd"]);
}
?>