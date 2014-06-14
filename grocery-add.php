<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id'];


	$querycheck = "SELECT DISTINCT `item_location` FROM `items` WHERE `user_id` = '$userId'";
	$query2check = "SELECT * FROM `items` WHERE `user_id` = '$userId'";

	

	$resultcheck = $link->query($querycheck);
	$result2check = $link->query($query2check);
	$rowcheck = $resultcheck->fetch_array();
	$row2check = $result2check->fetch_array();


	if(is_null($rowcheck)) {
		$query = "SELECT DISTINCT `item_location` FROM `items` WHERE `user_id` = '0' ORDER BY `item_location`";
		$result = $link->query($query);
	} else {
		$query = "SELECT DISTINCT `item_location` FROM `items` WHERE `user_id` = '$userId' ORDER BY `item_location`";
		$result = $link->query($query);
	}

	if(is_null($row2check)) {
		$query2 = "SELECT * FROM `items` WHERE `user_id` = '0'";
		$result2 = $link->query($query2);
		$row2 = $result2->fetch_array();
	} else {
		$query2 = "SELECT * FROM `items` WHERE `user_id` = '$userId'";
		$result2 = $link->query($query2);
		$row2 = $result2->fetch_array();
	}



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
?>	

<div id='addpage'>
<div id='addwrapper'>
	
<h3 class='formtitle'><i class='fa fa-plus'></i> Add Grocery Item</h3>
<form id='addform' method='post' action='grocery-add2.php'>

<?php
	foreach($row2 as $label => $value){
		if (is_string($label)) {
			if ($label == "item_needby") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>Need by:</label><input type='date' name='". $label ."' value='' placeholder='yyyy-mm-dd' />";
			} elseif ($label == "item_location") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label>";
				echo "<div class='styled-select-alt'><select id ='locationselect' name='" . $label . "'>";
				echo "<option selected>Not specified</option>";
				foreach($locations as $value) {
					echo "<option>" . $value . "</option>";
				}
				echo "<option>Add New...</option></select></div>";
				echo "<div id='locationselect2'><label></label><input type='text' name='item_location_new' value='' placeholder='Add Location' /></div>"; // alternate in jquery
			} elseif ($label == "item_category") {
				$categories = array("None", "Dairy", "Fish / Seafood", "Fruit", "Grocery", "Meat / Poultry",  "Sweet", "Vegetable");
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label>";
				echo "<div class='styled-select-alt'><select name='" . $label . "'>";
				foreach($categories as $value) {
					if ($value == "None") {
						echo "<option selected>" . $value . "</option>";
					} else {
						echo "<option>" . $value . "</option>";
					}
				}
				echo "</select></div>";
			} elseif ($label == "item_name" || $label == "item_size" || $label == "item_amount") {
				$inputName = ucwords(str_replace("item_", "", $label));
				echo "<label>" . $inputName . ":</label><input type='text' name='". $label ."' value='' />";
			} 
		}
	}

	?>
<div class='buttonwrapper'>
	<input class='formbutton' type='submit' value='Add Item' />
	<a class='cancel' href='index.php'>Cancel</a>
</div>
</form>
</div>
</div>


	