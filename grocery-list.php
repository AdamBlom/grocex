<?php
	require_once "functions.php";

	require_once "grocery-queryfilter.php";

	echo "<form method='post' action='grocery-deletemultiple.php'>";
	echo "<ul id='itemlist'>";

	$resultcheck = $link->query($query);
	$rowcheck = $resultcheck->fetch_array();
	if(is_null($rowcheck)) {
			echo "<li>No results found.</li></ul>";
	} else {
		$result = $link->query($query);
		while($row = $result->fetch_array()) {
			$itemId = "";
			$itemName = "";
			$itemAmount = "";
			$itemSize = "";
			$itemInfo = "";
			$itemLocation = "";
			$basketChecked = "";
			$basketClass = "";
			$catColorClass = "";
			$catColorClasses = array(
				'none' => 'cat-gray',
				'meat / poultry' => 'cat-red',
				'vegetable' => 'cat-green',
				'sweet' => 'cat-yellow',
				'grocery' => 'cat-purple',
				'fruit' => 'cat-orange',
				'dairy' => 'cat-white',
				'fish / seafood' => 'cat-pink'
			);
			foreach($row as $label=>$value) {
				if($label == "item_id") {
					$itemId = $value;
				} elseif ($label == "item_name"){
					$itemName = "<span class='foodname'>" . strtoupper($value) . "</span><br />";
				} elseif ($label == "item_needby"){
					$itemInfo = $itemInfo . "<i class='fa fa-calendar-o'></i> " . date('m/d/Y', strtotime($value));
				} elseif ($label == "item_category"){
					foreach($catColorClasses as $cat => $class) {
						if($value == $cat) {
							$catColorClass = $class;
						}	
					}
					$itemInfo = $itemInfo . "<i class='fa fa-tags'></i> " . ucwords($value) . "<br />"; 
				} elseif ($label == "item_amount"){
					$itemAmount = "<i class='fa fa-search'></i> " . ucfirst($value) . " - ";
				} elseif ($label == "item_size") {
					$itemSize = strtolower($value) . "<br />";
				} elseif ($label == "item_location"){
					$itemLocation = "<i class='fa fa-map-marker'></i> " . ucfirst($value) . "<br />";
				} elseif ($label == "item_inbasket") {
					if($value == 1) {
						$basketChecked = "checked";
						$basketClass = "cart-checked";
					}
				}
			}
			echo "<li class='$catColorClass $basketClass'><span class='list-info'>" . $itemName . $itemAmount . $itemSize . $itemLocation . $itemInfo . "</span><div class='list-buttons'><div class='checkbox_wrapper'><input id='item_check_".$itemId."' class='item_checkbox' name='inbasket' value='". $itemId . "' type='checkbox' $basketChecked /><label for='item_check_".$itemId."' class='item_checkbox_label'><i class='fa fa-shopping-cart'></i></label></div><div class='edit_wrapper'><a class='list-btn edit-btn' href='index.php?edit=active&item_id=" . $itemId . "'><i class='fa fa-pencil'></i></a><a class='list-btn delete-btn' href='grocery-delete.php?item_id=" . $itemId . "'><i class='fa fa-trash-o'></i></a></div><div class='clear'></div></div><div class='clear'></div></li>";
		}
		echo "<div class='clear'></div></ul>";
		echo "<div id='removeall'><label>Remove all items in basket from list? </label><input type='submit' value='Remove' /></div>";
	}
	echo "</form>";

	require_once "grocery-add.php";

	if(isset($_GET['edit'])) {
		if ($_GET['edit'] == "active" || $_GET['edit'] == "fail"){
			require_once "grocery-edit.php";
			//include fail message in grocery-edit?
		}
	}
	

?>