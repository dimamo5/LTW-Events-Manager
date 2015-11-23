<?php ob_start();
include_once 'databaseConnection.php';
session_start();

if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (login($username, $password)) {
        echo $_SESSION["userId"];
    } 
} else {
    echo "Invalid Request";
}
ob_end_flush();
?>