<?php
	require_once "functions.php";

	$user_id = $_SESSION['active']['user_id'];

	if ($link->escape_string($_POST['sendtoemailaddress']) == "Self"){
		$sendtoemailaddress = $_SESSION['active']['user_email'];
	} else {
		$sendtoemailaddress = $link->escape_string(strtolower($_POST['sendtoemailaddress2']));
	}

	if ($link->escape_string($_POST['emaillistcontent']) == "Current View") {
		require_once "grocery-queryfilter.php";
		$emailquery = $query;
	} else {
		$emailquery = "SELECT * FROM `items` WHERE `user_id` = '$user_id'";
	}
	$name = ucfirst($_SESSION['active']['user_firstname']) . " " . ucfirst($_SESSION['active']['user_lastname']);
	$fromemail = $_SESSION['active']['user_email'];
	$subject = "Grocery List from " . $name;

	$result = $link->query($emailquery);
	$messagelist = "";
	while($row = $result->fetch_array()) {
		$itemId = "";
		$itemName = "";
		$itemAmount = "";
		$itemSize = "";
		$itemInfo = "";
		$itemLocation = "";
		foreach($row as $label=>$value) {
			if($label == "item_id") {
				$itemId = $value;
			} elseif ($label == "item_name"){
				$itemName = "<span class='foodname'>" . strtoupper($value) . "</span><br />";
			} elseif ($label == "item_needby"){
				$itemInfo = $itemInfo . "Need By: " . $value . "<br />";
			} elseif ($label == "item_category"){
				$itemInfo = $itemInfo . "Category: " . ucwords($value) . "<br />"; 
			} elseif ($label == "item_amount"){
				$itemAmount = ucfirst($value) . "x ";
			} elseif ($label == "item_size") {
				$itemSize = strtolower($value) . "<br />";
			} elseif ($label == "item_location"){
				$itemLocation = "Location: " . ucfirst($value) . "<br />";
			}
		}
		$messagelist = $messagelist .  "<li>" . $itemName . $itemInfo . $itemAmount . $itemSize . $itemLocation . "</li>";
	}
		
	$html = "
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset='utf-8' />
				<style>
				</style>
			</head>
			<body>
				<header>
					<h1>Grocery List sent from " . $name . "</h1>
					<h2>Powered by GrocEx! Making Grocery shopping just a little bit easier.</h2>
				</header>
				<main>
					<h3>The current items in your list are:</h3>
					<ul>" . $messagelist . "</ul>
				</main>	
				<footer>
					<h4>Don't have any account with GrocEx? <a href='http://www.lightprioritystudios.com/cdia/projects/grocex/'>Try it out today!</a></h4>
				</footer>			
			</body>
		</html>
	";

	

	$to = $sendtoemailaddress;

	$headers = 'From: "'. $name . '" <' . $fromemail . '>' . "\r\n" .
	"CC:" . "\r\n" . 
	"BCC:" . "\r\n" .
	"MIME-Version: 1.0" . "\r\n" . //These two lines are needed for HTML emails.
	"Content-type: text/html;charset=iso-8859-1" . "\r\n" . 
	"X-mailer: php";

	$subject = "GrocEx: " . $subject; //Adds tag to email subject to identify email for fitlering.

	$validator = 0;
	$errorcodeE = "";
	foreach($_POST as $label => $value) {
		if ($label == "sendtoemailaddress"){
			$validator = $validator;
		} elseif ($label == "sendtoemailaddress2") {
			if($_POST['sendtoemailaddress'] == "Self") {
				$validator = $validator;
			} else {
				if(strlen($value) <= 5) {// validates email address has at least 5 characters
					$validator++;
					$errorcodeE = $errorcodeE . "e";
				}
				if(strpos($value, '@') === false) { // validates that email address contains "@" and is preceded by at least 1 character. 
					$validator++;
					$errorcodeE = $errorcodeE . "a";
				}
			}
		}
	}

	if($validator == 0) {
		mail($to, $subject, $html, $headers);
		header('location: index.php?message=success');
		exit;
	} else {
		header('location: index.php?message=fail&errorcodeE=' . $errorcodeE);
		exit;
	}

	


?>