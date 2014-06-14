<?php
	require_once "functions.php";
	$userId = $_SESSION['active']['user_id'];

	//if(isset($_POST['save'])) {}
	//if(isset($_POST['delete'])) {}

	foreach($_POST as $value) {
		$itemId = $value;
		$query = "DELETE FROM `items` WHERE `item_id` = '$itemId' AND `user_id` = '$userId";
		$link->query($query);
	}

	
	header("location: " . $_SERVER['HTTP_REFERER']);
	exit;
	
?>