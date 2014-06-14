<?php
	require_once "functions.php";
?>

<li id='nav-filters'><span>Add Filter</span>
	<ul id="sortfilters">
		<form id="sortby" method="get">
			<h4>Filter by:</h4>
			<label for="alphaSpecific">Name</label>
			<div class='styled-select'>
				<select id="alphaSpecific" name="alpha"> 
					<?php
						$sortLetters = array("All", "A-E", "F-J", "K-O", "P-T", "U-Z", "0-9");
						$selectedAlpha = "All";
						if(isset($_GET['alpha'])) {
							$selectedAlpha = $_GET['alpha'];
						} 
						foreach ($sortLetters as $value) {
							if($value == $selectedAlpha) {
								echo "<option selected>" . $value . "</option>";
							} else {
								echo "<option>" . $value . "</option>";
							}
						}
					?>
				</select>
			</div>
			<label for="categories">Category</label>
			<div class='styled-select'> 
				<select id="categories" name="category">
					<?php
						$user_id = $_SESSION['active']['user_id']; 

						$query = "SELECT DISTINCT `item_category` FROM `items` WHERE `user_id` = '$user_id' ORDER BY `item_category`";
						$result = $link->query($query);
						if(isset($_GET['category'])) {
							$selectedCategory = $_GET['category'];
						} else {
							$selectedCategory = "All";
						}

						echo "<option>All</option>";
						while($row = $result->fetch_array()) {
							foreach($row as $label => $value) {
								if (is_string($label) && $label == "item_category") {
									if(ucfirst($value) == $selectedCategory) {
										echo "<option selected>" . ucfirst($value) . "</option>";
									} else {
										echo "<option>" . ucfirst($value) . "</option>";
									}
								}
							}
						}
					?>
				</select>
			</div>
			<label for="locations">Location</label> 
			<div class='styled-select'>
				<select id="locations" name="location">
					<?php
						$user_id = $_SESSION['active']['user_id']; 

						$query = "SELECT DISTINCT `item_location` FROM `items` WHERE `user_id` = '$user_id' ORDER BY `item_location`";
						$result = $link->query($query);
						if(isset($_GET['location'])) {
							$selectedLocation = $_GET['location'];
						} else {
							$selectedLocation = "All";
						}

						echo "<option>All</option>";
						while($row = $result->fetch_array()) {
							foreach($row as $label => $value) {
								if (is_string($label) && $label == "item_location") {
									if(ucfirst($value) == $selectedLocation) {
										echo "<option selected>" . ucfirst($value) . "</option>";
									} else {
										echo "<option>" . ucfirst($value) . "</option>";
									}
								}
							}
						}
					?>
				</select>
			</div>
			<?php
					if(isset($_GET['start-date'])) {
							echo "<label for='start-date'>Start Date</label><input id='start-date' type='date' name='start-date' value='" . $_GET['start-date'] . "'placeholder='yyyy-mm-dd' />";
						} else {
							echo "<label for='start-date'>Start Date</label><input id='start-date' type='date' name='start-date' placeholder='yyyy-mm-dd' />";
						}
					if(isset($_GET['end-date'])) {
							echo "<label for='end-date'>End Date</label><input id='end-date' type='date' name='end-date' value='" . $_GET['end-date'] . "'placeholder='yyyy-mm-dd' />";
						} else {
							echo "<label for='end-date'>End Date</label><input id='end-date' type='date' name='end-date' placeholder='yyyy-mm-dd' />";
						}
				?>
			<label for="order">Sort by</label>
			<div class='styled-select'> 
				<select id="order" name="orderby">
						<?php
							$orderType = array("date-added", "date-asc", "alpha-asc", "alpha-desc");
							if(isset($_GET['orderby'])) {
								$selectedOrder = $_GET['orderby'];
							} else {
								$selectedOrder = "date-added";
							}
							foreach($orderType as $value) {
								if($value == $selectedOrder) {
									$checked = "selected";
								} else {
									$checked = "";
								}
								if ($value == "alpha-asc"){
									$label = "Name (A to Z)";
								} elseif ($value == "alpha-desc"){
									$label = "Name (Z to A)";
								} elseif ($value == "date-asc"){
									$label = "Date Needed";
								} else {
									$label = "Date Added";
								}
								echo"<option value='" . $value . "' " . $checked . ">" . $label . "</option>";
							}
					?>
					</select>
				</div>
			<input class='formbutton' type="submit" value="Add Filter" />
		</form>
		
	</ul>
</li>

	




	