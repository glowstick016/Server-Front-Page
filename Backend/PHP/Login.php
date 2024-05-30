
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Starting Session 
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'login'){
	//Goal is to check the login credentials of the user to log them in 

	require_once "connect.php";
	require_once "sanitize.php";
	require_once "log.php";
	require_once "goat.php";

  // collect value of input field
	$name = $_REQUEST['fName'];
	$pass = $_REQUEST['fPass'];

	$resp = checkLogin($name,$pass);

	if($resp["auth"] === 1){
		$_SESSION['username'] = $name;
		$_SESSION['admin'] = $resp["admin"];

		setcookie(session_name(), session_id(), time() + 3600, "/");
	}
	header('Content-Type: application/json');
	echo json_encode($resp);
}


function checkLogin($name,$pass){
	//name: String - username of the whoever is logging in 
	//pass: String - password of the user to be checked 
	//Goal: Check the login and return the status 

	$resp = array("auth" => 0, "admin" => 0);
	
	// Implement username checks here
  	$checkUser = sanitizeUser($name,0);
	$checkEmail = sanitizeEmail($name,0);

	if($checkUser || $checkEmail){
		//Check all the rights
		$checkPass = CheckSeason($name,$pass);
		$rights = getRights($name);

		if($checkPass && $rights != 0){
			//Check for Admin rights
			$admin = getAdmin($name);
			$resp = array(
				"auth" => $rights,
				"admin" => $admin
			);
			
		//Error catching 
		}else if (!$checkPass){
			logs($name . ": Failed login attempt (Bad password)");
		}else{
			logs($name . ": Tried to access something they didn't have the rights to (Login page)");	
		}

	}else{ 
		logs($name . ": Failed login attempt (Failed sanitization)");
	}
	return $resp;
}
?>
