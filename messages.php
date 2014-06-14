<?php
	require_once "functions.php";

	if(isset($_GET['add'])){
		if($_GET['add'] == "success"){
			echo "<div class='message success'><p>Item successfully added to your grocery list!</p><div id='messageclose'>X</div></div>";
		} elseif ($_GET['add'] == "fail") {
			echo "<div class='message fail'><p>Uh-oh! Looks like you left something out. Please make sure all fields are filled in.</p><div id='messageclose'>X</div></div>";
		}
	} elseif(isset($_GET['edit'])){
		if($_GET['edit'] == "success"){
			echo "<div class='message success'><p>Item successfully updated!</p><div id='messageclose'>X</div></div>";
		} elseif ($_GET['edit'] == "fail") {
			echo "<div class='message fail'><p>Uh-oh! Looks like you left something out. Please make sure all fields are filled in.</p><div id='messageclose'>X</div></div>";
		}
	} elseif(isset($_GET['delete'])){
		if($_GET['delete'] == "success"){
			echo "<div class='message success'><p>Item successfully removed from your grocery list.</p><div id='messageclose'>X</div></div>";
		}
	} elseif (isset($_GET['newuser'])){
		if($_GET['newuser'] == "success"){
			$user_firstname = ucfirst($_SESSION['active']['user_firstname']);
			echo "<div class='message success'><p>Account successfully created!! <br />Welcome to GrocEx, " . $user_firstname . ". Start creating your first list by clicking the 'Add Item' button below.</p><div id='messageclose'>X</div></div>";
		}
		if($_GET['newuser'] == "fail"){
			$errors = "";
			if(isset($_GET['errorcode1'])) {
				if(strpos($_GET['errorcode1'], "d1") !== false) {
					$errors = $errors . "<p>The email address you entered is already in use. Please log in above or use a different email address.</p>";
				}
			} elseif (isset($_GET['errorcode2'])){
				if(strpos($_GET['errorcode2'], "e") !== false){
					$errors = $errors . "<p>The email address you entered is not valid. Please enter a valid email address. <span class='message-example'>Example: someone@example.com</span></p>";
				}
				if(strpos($_GET['errorcode2'], "p") !== false) {
					$errors = $errors . "<p>The password you entered is not valid. Passwords must be between 8 and 254 characters in length.</p>";
				}
				if(strpos($_GET['errorcode2'], "x") !== false) {
					$errors = $errors . "<p>The passwords entered did not match. Both passwords must match for successful registration.</p>";
				}
				if(strpos($_GET['errorcode2'], "f") !== false) {
					$errors = $errors . "<p>The first name entered is invalid. For registration, first names must contain between 2 and 254 characters.</p>";
				}
				if(strpos($_GET['errorcode2'], "l") !== false) {
					$errors = $errors . "<p>The last name entered is invalid. For registration, last names must contain between 2 and 254 characters.</p>";
				}
			}
			echo "<div class='message fail'><p>Uh-oh! We had a problem creating your account. Please correct the following and submit again:</p>" . $errors . "<div id='messageclose'>X</div></div>";
		}
	} elseif(isset($_GET['login'])){
		if($_GET['login'] == "success"){
			$user_firstname = ucfirst($_SESSION['active']['user_firstname']);
			echo "<div class='message success'><p>Welcome back, " . $user_firstname . "! Your current grocery list is below.</p><div id='messageclose'>X</div></div>";
		}
		if($_GET['login'] == "fail"){
			echo "<div class='message fail'><p>Uh-oh! Looks like you may have accidentally entered the wrong email address or password. <br />Please re-enter your email address and password and try again.</p><div id='messageclose'>X</div></div>";	
		}
	} elseif(isset($_GET['profile'])){
		if($_GET['profile'] == "delete"){
			echo "<div class='message success'><p>Sorry to see you go. Your account, and any associated lists, have been successfully deleted. <br/> If you wish to come back in the future, please register for a new account below.</p><div id='messageclose'>X</div></div>";
		}
		if(isset($_GET['editprofile'])) {
			if($_GET['editprofile'] == "success"){
				echo "<div class='message success'><p>Profile successfully updated!</p><div id='messageclose'>X</div></div>";
			} elseif($_GET['editprofile'] == "fail"){
				$errors = "";
				if(isset($_GET['errorcode1'])) {
					if(strpos($_GET['errorcode1'], "p1") !== false){
						$errors = $errors . "<p>The current password you entered did not match out records. Please try again.</p>";
					}
				} elseif (isset($_GET['errorcode2'])) {
					if(strpos($_GET['errorcode2'], "d1") !== false) {
						$errors = $errors . "<p>The email address you entered is already in use. Please log in below or use a different email address.</p>";
					}
				} elseif (isset($_GET['errorcode3'])){
					if(strpos($_GET['errorcode3'], "e") !== false){
						$errors = $errors . "<p>The email address you entered is not valid. Please enter a valid email address. <span class='message-example'>Example: someone@example.com</span></p>";
					}
					if(strpos($_GET['errorcode3'], "p") !== false) {
						$errors = $errors . "<p>The password you entered is not valid. Passwords must be between 8 and 254 characters in length.</p>";
					}
					if(strpos($_GET['errorcode3'], "x") !== false) {
						$errors = $errors . "<p>The passwords entered did not match. Both passwords must match for successful registration.</p>";
					}
					if(strpos($_GET['errorcode3'], "n") !== false) {
						$errors = $errors . "<p>The first name or last name entered is invalid. For registration, first and last names must contain between 2 and 254 characters.</p>";
					}
				}
				echo "<div class='message fail'><p>Uh-oh! We had a problem updating your account. Please correct the following and submit again:</p>" . $errors . "<div id='messageclose'>X</div></div>";
			}
		}
	} elseif (isset($_GET['message'])){
		if($_GET['message'] == "success") {
			echo "<div class='message success'><p>List successfully sent!</p><div id='messageclose'>X</div></div>";
		} elseif($_GET['message'] == "fail"){
			$errors = "";
			if(isset($_GET['errorcodeE'])) {
				if(strpos($_GET['errorcodeE'], "e") !== false || strpos($_GET['errorcodeE'], "a") !== false){
					$errors = $errors . "<p>The email address you entered is not valid. Please enter a valid email address. <br /><span class='message-example'>Example: someone@example.com</span></p>";
				}
			}
			echo "<div class='message fail'><p>Uh-oh! We had a problem sending your list. Please correct the following and submit again:</p>" . $errors . "<div id='messageclose'>X</div></div>";
		}
	}
?>