<?php
	require_once "functions.php";

	$email = $link->escape_string(strtolower($_POST['user-email']));
	$password = $link->escape_string($_POST['user-password']);
	
	$query = "SELECT * FROM `users` WHERE `user_email` = '$email'";

	$result = $link->query($query);
	$row = $result->fetch_array();

	if($result->num_rows == 1 && crypt($password, $row['user_password']) === $row['user_password']){
		$_SESSION['active'] = $row;
		header("location: index.php?login=success");
		exit;
	} else {
		header("location: index.php?login=fail");
		exit;
	}


?>