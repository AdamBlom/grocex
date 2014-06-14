<?php
	require_once "functions.php";

	$userId = $_SESSION['active']['user_id'];

	$query = "SELECT * FROM `users` WHERE `user_id` = '$userId'";

	$result = $link->query($query);

	echo "<ul id='profilelist'>";
	while($row = $result->fetch_array()) {
		$userInfo = "";
		$userPassword = "";
		foreach($row as $label=>$value) {
			if(is_string($label)) {
				if($label == "user_id") {
					$userId = $value;
				} elseif ($label == "user_password") {
					$labelClean = str_replace("user_", "", $label);
					$userPassword = $userPassword . ucfirst($labelClean) .  ": <em>***Hidden***</em>";
				} elseif ($label == "user_firstname" || $label == "user_lastname") {
					$labelClean = str_replace("n", "_N" ,str_replace("user_", "", $label));
					$userInfo = $userInfo . ucfirst(str_replace("_", " ", $labelClean)) . ": " . ucfirst($value) . "<br />";
				} else {
					$labelClean = str_replace("user_", "", $label);
					$userInfo = $userInfo . ucfirst(str_replace("_", " ", $labelClean)) . ": " . $value . "<br />";
				}
			}
		}
		echo "<li>" . $userInfo . $userPassword . "<br/><br/><div class='edit'><a href='index.php?profile=edit'>Edit Profile</a></div><div class='delete'><a href='grocery-deleteprofile.php'>Delete Account</a></div></li>";
	}
	echo "</ul>";

	if($_GET['profile'] == "edit") {
		require_once "grocery-editprofile.php";
	}



?>

