<?php
/*
//Get the week could still be needed for Sonarr calendar stuff 
$start = date('Y-m-d', strtotime('first day of this month'));
$end = date('Y-m-d', strtotime('last day of this month'));
$api="";
//echo "Start of month is: $start \nEnd of month is: $end \n";


$cal = "http:10.10.0.201:8989/api/calendar/?start=$start&end=$end&apikey=$api";
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_GET['action']) && $_GET['action'] == 'dispCalShows'){
	//Goal: Display a calendar for the user 
	
	$url = "https://calendar.google.com/calendar/ical/cjkenned%40udel.edu/private-6b134e998de980279bb0b2a7334c5697/basic.ics";

	$calData = file_get_contents($url);

	$calEvents = explode("BEGIN:VEVENT", $calData);
	array_shift($calEvents); //removes first empty line
	
	$month = date('m');
	$year = date('y');
	$totDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	
	$daysWithEvents = array();

	foreach ($calEvents as $event){
		preg_match('/SUMMARY:(.*?)\R/', $event, $summaryMatch);
		$sum = isset($summaryMatch[1]) ? $summaryMatch[1] : "No Summary";

		preg_match('/DTSTART:(.*?)\R/', $event, $summaryMatch);
		$start = isset($summaryMatch[1]) ? $summaryMatch[1] : "No Start date";

		//Checking for this month
		$startDate = date("y-m-d", strtotime($start));
		if (date('m', strtotime($startDate)) == $month && date('Y', strtotime($startDate)) == $year){
		
			$daysWithEvents[$startDate][] = array(
				'summary' => $sum,
				'start' => $start
			);
		}
	}

	echo '<div class="calendar">';

	for ($day = 1; $day <= $totDays; $day++){
		echo '<div class="calendar-day">';
		echo "<h3>$month/$day/$year</h3>";

		if (isset($daysWithEvents[$day]) && !empty($daysWithEvents[$day])){
			foreach ($events as $event){
				echo "<p><strong>{$event['summary']}</strong><br>Start: {$event['start']}</p>";
			}
		} else {
			echo "<p> No shows</p>";
		}

		echo '</div>';
	}
	echo '</div>';
}
?>
