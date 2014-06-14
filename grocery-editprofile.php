<?php
	require_once "functions.php";
	
	$userId = $_SESSION['active']['user_id'];

	$current_values = $link->query("SELECT * FROM `users` WHERE `user_id` = '$userId'");
	$row = $current_values->fetch_array();
	echo "
		<div id='editpage'>
		<div id='editwrapper'>
		";
	echo"<h3 class='formtitle'>Edit " . ucfirst($row['user_firstname']) . "'s Profile:</h3>";

		foreach($row as $label => $value){
			if(is_string($label)) {
				if($label == "user_id") {
					echo "<form id='editform' method='post' action='grocery-editprofile2.php?user_id=" . $value ."'>";
				} elseif ($label == "user_firstname" || $label == "user_lastname") {
					$labelClean = str_replace("n", "_N" ,str_replace("user_", "", $label));
					$inputName = ucfirst(str_replace("_", " ", $labelClean));
					echo "<label>" . $inputName . ":</label><input type='text' name='". $label ."' value='" . ucfirst($value) . "' />";
				} elseif ($label == "user_password") {
					echo "<div>To change password, enter current password and new password.</div>";
					echo "<label>Current Password</label><input type='password' name='current_password' placeholder='Enter current password' />";
					echo "<label>New Password</label><input type='password' name='new_password' placeholder='Enter new password' />";
					echo "<label>Re-enter New Password</label><input type='password' name='new_password2' placeholder='Re-enter new password' />";
				}
			}	
		}
	?>
	<input class='formbutton' type='submit' value='Update Profile' />
	<div class='cancel'><a href='index.php?profile=active'>Cancel</a></div>
	</form>
	</div>
	</div>
		
		
	