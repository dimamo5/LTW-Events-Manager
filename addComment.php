<?php
	session_start();
	require_once('databaseConnection.php');
	$idPost=$_GET['idPost'];
	$idUser=$_GET['idUser'];
	$comment=$_GET['comment'];

	echo $idPost;
	echo " ";
	echo $idUser;
	

	$user=addComment($idPost,$idUser,$comment);


	$id= $_GET['idEvent'];
	header("Location: event.php?id=$id");
?>