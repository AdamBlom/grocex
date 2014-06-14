<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id'];

	$query = "DELETE FROM `users` WHERE `user_id` = '$userId'";
	$link->query($query);
	$query2 = "DELETE FROM `items` WHERE `user_id` = '$userId'";
	$link->query($query2);
	session_destroy(); 
	unset($_SESSION['active']); 
	header("location:index.php?profile=delete"); 
	exit;	
	
?>