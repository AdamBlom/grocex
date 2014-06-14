<?php
	require_once "functions.php";

	function filterClear ($filtervariable1, $filtervariable2, $filtertype) {
		$parseURL = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$queryParams = array();
		parse_str($parseURL['query'], $queryParams);
		unset($queryParams[$filtervariable1]);
		unset($queryParams[$filtervariable2]);
		$queryString = http_build_query($queryParams);
		$url = $parseURL['path'] . "?" . $queryString;
		echo "<div class='filterTag'><a href='" . $url . "'>" . $filtertype . " <span class='removefiltertag'>X</span></a></div>";
	}


	if(isset($_GET['alpha']) || isset($_GET['location']) || isset($_GET['category']) || isset($_GET['orderby']) || (isset($_GET['start-date']) && isset($_GET['end-date'])) ){ 
		echo "<div id='filtertags'>";
		if ((!isset($_GET['alpha']) || $_GET['alpha'] == "All") && (!isset($_GET['location']) || $_GET['location'] == "All") && (!isset($_GET['category']) || $_GET['category'] == "All") && !isset($_GET['orderby']) && ((!isset($_GET['start-date']) && !isset($_GET['start-date'])) || ($_GET['start-date'] == "" && $_GET['end-date'] == ""))) {
			echo "<div class='filterTag'><p>No filters applied</p></div>";
		} else {
			echo "<span id='filterTitle'>Filters:</span>";
			if (isset($_GET['alpha'])) {
				if($_GET['alpha'] != "All") {
					filterClear('alpha', "", "Name: " . ucfirst($_GET['alpha']));
				}	
			}
			if (isset($_GET['location'])) {
				if($_GET['location'] != "All") {
					filterClear('location', "", "Location: " . ucfirst($_GET['location']));
				}
			}
			if (isset($_GET['category'])) {
				if($_GET['category'] != "All") {
					filterClear('category', "", "Category: " . ucfirst($_GET['category']));
				}
			}
			if (isset($_GET['start-date']) && isset($_GET['end-date'])) {
				if($_GET['start-date'] != "" || $_GET['end-date'] != "") {
					$endDate  = "";
					$startDate = "";
					if($_GET['end-date'] == "") {
						$endDate = "Today";
					} else {
						$endDate = $_GET['end-date'];
					}
					if($_GET['start-date'] == "") {
						$startDate = "Start";
					} else {
						$startDate = $_GET['start-date'];
					}
					$daterange = "Date Range: "  . $startDate . " to " . $endDate;
					filterClear('start-date', 'end-date', $daterange);
				}
			}
			if (isset($_GET['orderby'])) {
				if($_GET['orderby'] == "date-added") {
					$orderLabel = "Date Added";
				} elseif($_GET['orderby'] == "date-asc") {
					$orderLabel = "Date Needed";
				} elseif($_GET['orderby'] == "alpha-asc") {
					$orderLabel = "Name (A to Z)"; 
				} elseif($_GET['orderby'] == "alpha-desc") {
					$orderLabel = "Name (Z to A)";
				}
				filterClear('orderby', "", "Order: " . $orderLabel);
			}
		}
	} else {
		echo "<div class='hidden-tags' id='filtertags'>";
	}
	echo "</div>";
?>
