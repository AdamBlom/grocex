<?php
	require_once "functions.php";

	session_destroy(); 
	unset($_SESSION['active']); 
	header("location:index.php"); 
	exit;
?>