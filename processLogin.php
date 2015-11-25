<?php ob_start();
session_start();
include_once('databaseConnection.php');

if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (login($username, $password)) {
        echo json_encode(["login"=>$_SESSION["userId"]]);
    }else{
        $data=array("login"=>"error");
        echo json_encode($data);
    }
} else {
    echo json_encode(["login"=>"error"]);
}
ob_end_flush();
?>