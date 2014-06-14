<?php
	require_once "functions.php";
?>
<div id="register-background">
	<div id="registerbox">
		<h1>GrocEx</h1>
		<h2><em>Your grocery list just got a little bit easier.</em></h2>

		<p class='landing-description'>Welcome to GrocEx! This web tool lets you create, maintain, and send grocery lists. Keep a long running list or just make a list for the week. Either way GrocEx will help you get in and out of the store faster.</p>
		<p class='landing-description'>If this is your first time here, register below. It's free and always will be. If you have an account, log in above.</p>

		<form id="grocery-register" method="post" action="grocery-register2.php">
			<label for="first_name">First Name:</label><input id="first_name" type="text" name="user-firstname" placeholder="First name" />
			<label for="last_name">Last Name:</label><input id="last_name" type="text" name="user-lastname" placeholder="Last name" />
			<label for="email">Email Address:</label><input id="email" type="email" name="user-email" placeholder="Email address" />
			<label for="password">Password:</label><input id="password" type="password" name="user-password" placeholder="Password" />
			<label for="password2">Re-enter Password:</label><input id="password2" type="password" name="user-password2" placeholder="Re-enter password" />
			<div class='buttonwrap'>
				<input type="reset" value="Clear" />
				<input type="submit" value="Create Account" />
			</div>
		</form>
	</div>
</div>