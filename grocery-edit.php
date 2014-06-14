<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id'];
	$item_id = $_GET['item_id'];

	$query = "SELECT DISTINCT `item_location` FROM `items` WHERE `user_id` = '$userId' ORDER BY `item_location`";
	$query2 = "SELECT * FROM `items` WHERE `item_id` = '$item_id'";
	$result = $link->query($query);
	$result2 = $link->query($query2);
	$row2 = $result2->fetch_array();

	$locations = array();
	$index = 0;
	while($row = $result->fetch_array()){
		foreach ($row as $label => $value) {
			if(is_string($label)) {
				if ($label == "item_location") {
					if($value == "Not specified") {
						$index = $index;
					} else {
						$locations[$index] = ucfirst($value);
						$index++;
					}
				}
			}
		}
	}
	echo "
		<div id='editpage'>
		<div id='editwrapper'>
		";
	echo"<h3 class='formtitle'>Edit Grocery Item: " . $row['item_name'] . "</h3>
		";

		foreach($row2 as $label => $value){
			if($label == "item_id") {
				echo "<form id='editform' method='post' action='grocery-edit2.php?item_id=" . $value ."'>";
			} elseif ($label == "item_needby") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>Need by:</label><input type='date' name='". $label ."' value='" . $value . "' placeholder='yyyy-mm-dd' />";
			} elseif ($label == "item_location") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label>";
				echo "<select id='locationselect' name='" . $label . "'><option>Not specified</option>";
				foreach($locations as $locationvalue) {
					if (strtolower($locationvalue) ==  $row2['item_location']) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo "<option " . $selected . ">" . $locationvalue . "</option>";
				}
				echo "<option>Add New...</option></select>";

				echo "<div id='locationselect2'><label></label><input  type='text' name='item_location_new' value='' placeholder='Add Location' /></div>"; // alternate in jquery
			} elseif ($label == "item_category") {
				$categories = array("None", "Dairy", "Fish/Seafood", "Fruit", "Grocery", "Meat", "Poultry",  "Sweet", "Vegetable");
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label>";
				echo "<select name='" . $label . "'>";
				foreach($categories as $categoryvalue) {
					if (strtolower($categoryvalue) ==  $row2['item_category']) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo "<option " . $selected . ">" . $categoryvalue . "</option>";
				}
				echo "</select>";
			} elseif ($label == "item_name" || $label == "item_size" || $label == "item_amount") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label><input type='text' name='". $label ."' value='" . $value . "' />";
			}
		}
?>
		<input class='formbutton' type='submit' value='Update Item' />
		<div class='cancel'><a href='index.php'>Cancel</a></div>
		</form>
		</div>
		</div>
		
		
	