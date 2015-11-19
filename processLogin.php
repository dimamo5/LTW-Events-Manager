<?php ob_start();
include_once 'includes/func.php';
session_start();
if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (login($username, $password)) {
        header('Location:index.php');
    } else {
        header('Location:login.php?error=1');
    }
} else {
    echo "Invalid Request";
}
ob_end_flush();
?>