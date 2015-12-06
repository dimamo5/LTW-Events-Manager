<?php

	require_once('databaseConnection.php');
	$idPost=$_GET['idPost'];
	$idUser=$_GET['idUser'];
	$comment=$_GET['comment'];


	$user=addComment($idPost,$idUser,$comment);

	$id= $_GET['idEvent'];
	header("Location: event.php?id=$id");
?>