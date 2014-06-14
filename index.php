<?php
	require_once "functions.php";


	//IDEAS FOR EXPANSION: 
	//javascript validation.
	//Add in favorites list (uses separate database table to maintain and pull up as desired).
	//Add in ability to add in own categories. Default list would be available to all and then can add in new items that are user specific.
	//Add in ability to have multiple grocery lists. 
	//Add in ability to specify store. Location could be location within a store.
	//AJAX interactions
	//SAve backet state if no JS.
?>
<!DOCTYPE html>
<!--[if IE 8 ]>		 <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>		 <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en-US">
<!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
		<meta name="description" content="GrocEx (short for Groceries Expedited) is a an online tool to help you keep track of your grocery list at home and on the go." />
		<title>GrocEx - A grocery list, just easier.</title>
		<link rel='stylesheet' href='css/reset.css' />
		<link rel='stylesheet' href='css/grocery.css' />
		<link rel='stylesheet' href='css/font-awesome-4.0.3/css/font-awesome.min.css' />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script src="js/grocery.js"></script>
		<?php
			if(isset($_SESSION['active'])){
				echo "<link rel='stylesheet' href='css/grocery-internal.css' />";
				echo "<script src='js/grocery-internal.js'></script>";
				if (isset($_GET['profile'])) {
					echo "<link rel='stylesheet' href='grocery-profile.css' />";	
				}
			} else {
				echo "<link rel='stylesheet' href='css/grocery-landing.css' />";
				echo "<script src='js/grocery-landing.js'></script>";
			}
		?>
	</head>
	<body>
		<?php
			require_once "messages.php";
		?>
		<!--[if lt IE 9]>
			<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
		<![endif]-->
		<div id="grocery-wrapper">
			<header>
				<?php
					if(!isset($_SESSION['active'])){
						require_once "grocery-login.php";
					} else {
						echo "<h1>GrocEx</h1>";
						echo "<h2><em>Your grocery list just got a little bit easier.</em></h2><div class='clear'></div>";
						if(!isset($_GET['profile'])) {
							//echo "<div class='additemtop'><a href='index.php?add=active'>Add Item</a></div>";
						}
					}
				?>
			</header>
			<nav>
				<?php
					if(isset($_SESSION['active'])) {
						require_once "grocery-nav.php";
						require_once "grocery-filtertags.php";
					}
				?>
			</nav>
			<div id='contentwrapper'>
			<main>
				<?php
					if(isset($_SESSION['active'])){	
						if(isset($_GET['profile'])) {
							require_once "grocery-profile.php";
						} else {
							require_once "grocery-list.php";
						}
					} else {
						require_once "grocery-register.php";
					}
				?>
			</main>
		</div>
		<footer>
			<h6>Copyright &copy;2013-<?php echo date('Y'); ?>. <a href="http://www.lightprioritystudios.com" target="_blank">Light Priority Studios</a>.</h6>
		</footer>
		</div>
		<script>

		</script>
	</body>
</html>