<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id'];
	$itemId = $_GET['item_id'];

	$query = "DELETE FROM `items` WHERE `item_id` = '$itemId' AND `user_id` = '$userId";

	$link->query($query);
	header("location: index.php?delete=success");
	exit;
	
?>