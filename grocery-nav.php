<?php
	require_once "functions.php";

?>

<ul>
	<?php
		if(isset($_GET['profile'])) {
			echo "<li><a href='index.php'>Return to List</a></li>";
		} else {
			echo "<li id='viewall'><a href='index.php'>View All</a></li>";
			require_once "grocery-navfilters.php";
			$parseURL = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			$queryParams = array();
			if(isset($_GET['alpha']) || isset($_GET['location']) || isset($_GET['category']) || isset($_GET['start-date']) || isset($_GET['end-date']) || isset($_GET['orderby'])) {
				parse_str($parseURL['query'], $queryParams);
				$queryString = http_build_query($queryParams);
			} else {
				$queryString = "";
			}			
			$url = "grocery-mail2.php?" . $queryString;
			echo "<li id='nav-email'><span>Email List</span>
					<ul id='email-list'>
						<form method='post' action='" . $url . "'>
							<label for='emaillist'>Send To</label>
								<div class='styled-select'>
									<select id='emaillist' name='sendtoemailaddress'>
										<option selected>Self</option>
										<option>Other</option>
									</select>
								</div>
								<div id='emaillist2'>
								<label>Email Address</label><input type='email' name='sendtoemailaddress2' placeholder='Enter email address' />
								</div>
								<label for='emaillistcontent'>List</label>
								<div class='styled-select'>
									<select id='emaillistcontent' name='emaillistcontent'>
										<option selected>Current View</option>
										<option>Entire List</option>
									</select>
								</div>
							<input class='formbutton' type='submit' value='Send' />
						</form>
						
					</ul>
			</li>
			<li id='nav-profile'><a href='index.php?profile=active'>Profile</a></li>";
		}
	?>
	<li id='logout'><a href='grocery-logout.php'>Log Out</a></li>
	<div class='clear'></div>
</ul>
	

