<?php
	require_once "functions.php";

	$firstname = $link->escape_string(strtolower($_POST['user-firstname']));
	$lastname = $link->escape_string(strtolower($_POST['user-lastname']));
	$password = $link->escape_string($_POST['user-password']);
	$password_encrypted = crypt($password);
	$password2 = $link->escape_string($_POST['user-password2']);
	$email = $link->escape_string(strtolower($_POST['user-email']));

	//Validates for duplicate username and duplicate user email.
	$query = "SELECT * FROM `users`";
	$result = $link->query($query);

	$validator1 = 0;
	$errorcode1 = "";
	while($row = $result->fetch_array()) {
		foreach($row as $label => $value) {
			if ($label == "user_email"){
				if ($value == $email) {
					$validator1++;
					$errorcode1 = $errorcode1 . "d1";
				}
			}
		}
	} 

	if($validator1 != 0) {
		header("location: index.php?newuser=fail&errorcode1=" . $errorcode1);
		exit;
	}

	$query2 = "INSERT INTO `users` (`user_firstname`, `user_lastname`, `user_password`, `user_email`) VALUES ('$firstname', '$lastname', '$password_encrypted', '$email')";
	
	//Validates formats, lengths and confirms password entry and generates errorcode for alerting user.
	$validator2 = 0;
	$errorcode2 = ""; 
	foreach($_POST as $label => $value){
		if ($label =="user-email") {
			$preg_email = '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
			if($value != "" && !preg_match($preg_email, $value)) {
				$validator2++;
				$errorcode2 .= "e";
			}
		} elseif ($label == "user-password") {
			if (strlen($value) <= 7 || strlen($value) >= 254) { // validates length of password
				$validator2++;
				$errorcode2 = $errorcode2 . substr($label, 5 , 1);
			}
			if ($password !== $password2) {	//validates entries of password match
				$validator2++;
				$errorcode2 = $errorcode2 . "x";
			}
		} elseif(strlen($value) <= 1 || strlen($value) >= 254) { //validates that each other entry has at least two characters
			$validator2++;
			$errorcode2 = $errorcode2 . substr($label, 5 , 1);
		}
	}

	if($validator2 == 0) {
		$link->query($query2);
		$query3 = "SELECT * FROM `users` WHERE `user_email` = '$email'"; 
		$result3 = $link->query($query3);
		$row3 = $result3->fetch_array();
		$_SESSION['active'] = $row3;
		header("location: index.php?newuser=success");
		exit;
	} else {
		header("location: index.php?newuser=fail&errorcode2=" . $errorcode2);
		exit;
	}
	

?>