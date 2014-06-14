<?php
	require_once "functions.php";

	$firstname = $link->escape_string(strtolower($_POST['user_firstname']));
	$lastname = $link->escape_string(strtolower($_POST['user_lastname']));
	$cpassword = $link->escape_string($_POST['current_password']);
	$password = $link->escape_string($_POST['new_password']);
	$password_encrypted = crypt($password);
	$password2 = $link->escape_string($_POST['new_password2']);
	$email = $link->escape_string(strtolower($_POST['user_email']));


	$userId = $_SESSION['active']['user_id'];

	//Validates current password matches password in database.
	$query = "SELECT * FROM `users` WHERE `user_id` = '$userId'";
	$result = $link->query($query);
	$row = $result->fetch_array();
	
	$validator1 = 0;
	$errorcode1 = "";
	if ($cpassword == "" && $password == "" && $password2 == "") {
				$validator1 = $validator1;
	} else {
		if (crypt($cpassword, $row['user_password']) !== $row['user_password']) { 
			$validator1++;
			$errorcode1 .= "p1";
		}
	}
 

	if($validator1 != 0) {
		header("location: index.php?profile=edit&editprofile=fail&errorcode1=" . $errorcode1);
		exit;
	}


	//Validates for duplicate username and duplicate user email.
	$query2 = "SELECT * FROM `users` WHERE `user_id` != '$userId'";
	$result2 = $link->query($query2);

	$validator2 = 0;
	$errorcode2 = "";
	while($row2 = $result2->fetch_array()) {
		foreach($row2 as $label => $value) {
			if ($label == "user_email"){
				if ($value == $_SESSION['active']['user_email']) {
					$validator2 = $validator2;
				} elseif ($value == $email) {
					$validator2++;
					$errorcode2 .= "d1";
				}
			}
		}
	} 

	if($validator2 != 0) {
		header("location: index.php?profile=edit&editprofile=fail&errorcode2=" . $errorcode2);
		exit;
	}
	
	if ($cpassword == "" && $password == "" && $password2 == "") {
		$query3 = "UPDATE `users` SET `user_firstname` = '$firstname', `user_lastname` = '$lastname',  `user_email` = '$email' WHERE `user_id` =  '$userId'";
	} else {
		$query3 = "UPDATE `users` SET `user_firstname` = '$firstname', `user_lastname` = '$lastname', `user_password` = '$password_encrypted', `user_email` = '$email' WHERE `user_id` =  '$userId'";
	}
	
		
	
	//Validates formats, lengths and confirms password entry and generates errorcode for alerting user.
	$validator3 = 0;
	$errorcode3 = ""; 
	foreach($_POST as $label => $value){
		if ($label =="user_email") {
				$preg_email = '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
				if($value != "" && !preg_match($preg_email, $value)) {
					$validator3++;
					$errorcode3 .= "e";
				}
		} elseif ($label == "new_password") {
			if ($cpassword == "" && $password == "" && $password2 == "") {
				$validator3 = $validator3;
			} else {
				if (strlen($value) <= 7 || strlen($value) >= 254) { // validates length of password
					$validator3++;
					$errorcode3 .= "p";
				}
				if ($password !== $password2) {	//validates entries of password match
					$validator3++;
					$errorcode3 .= "x";
				}
			}
		} elseif ($label ==  "user_firstname" || $label ==  "user_lastname") {
			 if(strlen($value) <= 1 || strlen($value) >= 254) { //validates that each other entry has at least two characters
				$validator3++;
				$errorcode3 .= "n";
			}
		}
	}

	if($validator3 == 0) {
		$link->query($query3);
		$query4 = "SELECT * FROM `users` WHERE `user_email` = '$email'"; 
		$result4 = $link->query($query4);
		$row4 = $result4->fetch_array();
		$_SESSION['active'] = $row4;
		header("location: index.php?profile=active&editprofile=success");
		exit;
	} else {
		header("location: index.php?profile=edit&editprofile=fail&errorcode3=" . $errorcode3);
		exit;
	}

?>