<?php
	require_once "functions.php";
?>
<div id="login-background">
	<form method="post" action="grocery-login2.php">
		<label for="user_email">Email Address:</label><input id="user_email" type="text" name="user-email" placeholder="Email Address" />
		<label for="password">Password:</label><input id="password" type="password" name="user-password" placeholder="Password" />

		<input type="submit" value="Log in" />
	</form>
</div>