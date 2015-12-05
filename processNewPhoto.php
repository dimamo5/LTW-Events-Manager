<?php
session_start();
include_once('databaseConnection.php');

if(!isset($_POST["nrfiles"],$_POST["eventId"])){
    echo json_encode(["fileupload"=>"failed"]);
    die();
}

$nr=$_POST["nrfiles"];

$target_dir = "static/event/".$_SESSION['userId'].'/';
if(!is_dir($target_dir)){
    mkdir($target_dir,0777,true);
}

for($i=0;$i<$nr;$i++){
    $filename="file".$i;
    $target_file = $target_dir . basename($_FILES[$filename]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$filename]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    if ($_FILES[$filename]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES[$filename]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $photoId=addPhoto(htmlspecialchars($target_file));
    
    if(!addPhotoEvent($_POST["eventId"],$photoId)){
        echo json_encode(["fileupload"=>"failed adding database"]);
        die();
    }
    
    echo json_encode(["fileupload"=>"success"]);
    
    
}
?>