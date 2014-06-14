<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id']; 

	$itemName = $link->escape_string(strtolower($_POST['item_name']));
	$itemAmount = $link->escape_string(strtolower($_POST['item_amount']));
	$itemSize = $link->escape_string(strtolower($_POST['item_size']));
	if ($_POST['item_location'] == "Add New...") {
		$itemLocation = $link->escape_string(strtolower($_POST['item_location_new']));
	} else {
		$itemLocation = $link->escape_string(strtolower($_POST['item_location']));
	}
	$itemCategory = $link->escape_string(strtolower($_POST['item_category']));
	$itemNeedby = $link->escape_string($_POST['item_needby']);
	
	$itemId = $_GET['item_id'];

	$query = "UPDATE `items` SET `item_name` = '$itemName', `item_amount` = '$itemAmount', `item_size` = '$itemSize', `item_location` = '$itemLocation', `item_category` = '$itemCategory', `item_needby` = '$itemNeedby' WHERE `item_id` =  '$itemId' AND `user_id` = '$userId'";
	
	$validator = 0;
	foreach($_POST as $label => $value) {
		if($label == 'item_location' || $label == 'item_location_new') {
			if($itemLocation == "") {
				$validator++;
			}
		} elseif(strlen($value) == 0) {
			$validator++;
		}
	}


	if($validator == 0) {
		$link->query($query);
		header('location: index.php?edit=success');
		exit;
	} else {
		header('location: index.php?edit=fail&item_id='. $itemId);
		exit;
	}

?>