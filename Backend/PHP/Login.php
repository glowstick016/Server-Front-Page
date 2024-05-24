
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Starting Session 
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'login'){

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
	$resp = array("auth" => 0, "admin" => 0);
	// Implement username checks here
  	$checkUser = sanitizeUser($name,0);
	$checkEmail = sanitizeEmail($name,0);

	if($checkUser || $checkEmail){
		//Check all the rights
		//echo "Verified User passed sanitization\n";
		$checkPass = CheckSeason($name,$pass);
		//echo "Password was: $checkPass eheh\n";
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
			//echo "<p> Username/Password was inccorect try again</p>";
			logs($name . ": Failed login attempt (Bad password)");
		}else{
			//echo "<p> You haven't been given the right rights for this </p>";
			logs($name . ": Tried to access something they didn't have the rights to (Login page)");	
		}

	}else{ 
		//echo "<p> Email/Username didn't pass didn't pass the checks</p>";
		logs($name . ": Failed login attempt (Failed sanitization)");
	}
	return $resp;
}
//checkLogin("cjkenned","scooby016!!");
?>
