<?php
	require_once "functions.php";

	$itemName = $link->escape_string(strtolower($_POST['item_name']));
	$itemAmount = $link->escape_string(strtolower($_POST['item_amount']));
	$itemSize = $link->escape_string(strtolower($_POST['item_size']));
	if (!isset($_POST['item_location']) || $_POST['item_location'] == "Add New...") {
		$itemLocation = $link->escape_string(strtolower($_POST['item_location_new']));
	} else {
		$itemLocation = $link->escape_string(strtolower($_POST['item_location']));
	}
	$itemCategory = $link->escape_string(strtolower($_POST['item_category']));
	$itemNeedby = $link->escape_string($_POST['item_needby']);
	$userId = $_SESSION['active']['user_id'];

	$query = "INSERT INTO `items` (`item_name`, `item_amount`, `item_size`, `item_location`, `item_category`, `item_needby`, `user_id`) VALUES ('$itemName', '$itemAmount', '$itemSize', '$itemLocation', '$itemCategory', '$itemNeedby', '$userId')";


	$validator = 0;
	foreach($_POST as $key => $value) {
		if($key == 'item_location' && $value == "Add New...") {
			if(strlen($_POST['item_location_new']) == 0) {
				$validator++;
			}
		} elseif($key == 'item_location_new') {
			$validator = $validator;
		} else {
			if(strlen($value) == 0) {
				$validator++;
			}
		}
	}


	if($validator == 0) {
		$link->query($query);
		header('location: index.php?add=success');
		exit;
	} else {
		header('location: index.php?add=fail');
		exit;
	}
?>