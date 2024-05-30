<?php

session_start();

if(isset($_SESSION['username'])){
	//Goal: get the user session for if they're logged in and admin rights 

	$tmp = array("auth" => 1, "admin" => $_SESSION['admin']);

}else{ $tmp = array("auth" => 0, "admin" => 0);}

header('Content-Type: application/json');
echo json_encode($tmp);

?>
