<?php
	require_once "functions.php";

	$user_id = $_SESSION['active']['user_id'];

	$query = "SELECT * FROM `items` WHERE `user_id` = '$user_id'";
	if (isset($_GET['location'])) {
		if($_GET['location'] != "All") {
			$location = strtolower($_GET['location']);
			$query = $query . " AND `item_location` = '$location'";
		}
	}
	if (isset($_GET['category'])) {
		if($_GET['category'] != "All") {
			$category = strtolower($_GET['category']);
			$query = $query . " AND `item_category` = '$category'";
		}
	}
	if(isset($_GET['alpha'])) {
		if ($_GET['alpha'] == "A-E") {
			$query = $query . " AND `item_name` BETWEEN 'a' AND 'e'";
		} elseif ($_GET['alpha'] == "F-J") {
			$query = $query . " AND `item_name` BETWEEN 'f' AND 'j'";
		} elseif ($_GET['alpha'] == "K-O") {
			$query = $query . " AND `item_name` BETWEEN 'k' AND 'o'";
		} elseif ($_GET['alpha'] == "P-T") {
			$query = $query . " AND `item_name` BETWEEN 'p' AND 't'";
		} elseif ($_GET['alpha'] == "U-Z") {
			$query = $query . " AND `item_name` BETWEEN 'u' AND 'z'";
		} elseif ($_GET['alpha'] == "0-9") {
			$query = $query . " AND `item_name` BETWEEN '0' AND '9'";
		}
	}
	if(isset($_GET['start-date']) || isset($_GET['end-date'])) {
		$sdate = $_GET['start-date'];
		$edate = $_GET['end-date'];
		if($sdate != "" || $edate != "") {
			if($sdate == "") {
				$query = $query . " AND `item_needby` <= '$edate'"; 
			} elseif ($edate == "") {
				$query = $query . " AND `item_needby` >= '$sdate'"; 
			} else {
				$query = $query . " AND `item_needby` BETWEEN '$sdate' AND '$edate'";
			}
		}
	}
	if(isset($_GET['orderby'])) {
		if($_GET['orderby'] == "alpha-asc") {
			$query = $query . " ORDER BY `item_name` ASC";
		} elseif($_GET['orderby'] == "alpha-desc") {
			$query = $query . " ORDER BY `item_name` DESC";
		} elseif($_GET['orderby'] == "date-asc") {
			$query = $query . " ORDER BY `item_needby`";
		}
	}

?>