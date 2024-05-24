<?php
session_start();


if(isset($_SESSION['username'])){

	$usr = $_SESSION['username'];
	$admin = $_SESSION['admin'];

	$sessionDetails = "Username: $usr<br>";
	$sessionDetails .= "Admin: " . ($admin ? 'Yes' : 'No') . "<br>";

	echo $sessionDetails;

} else{ 
	$sessionDetails = "No logged in";
	echo $sessionDetails;
}
?>
