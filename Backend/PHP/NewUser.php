<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_POST['action']) && $_POST['action'] == 'newUser') {
	//Goal: Set a new user up in the database 

	// Configure file for MySQL change to call a function

	require_once "connect.php";
	require_once "sanitize.php";
	require_once "log.php";
	require_once "goat.php";

	$name = $_POST['fName'];
	$email = $_POST['fEmail'];
	$pass = $_POST['fPass'];
	$extra = $_POST['fExtra'];

	$resp = processUser($name, $email, $pass, $extra);
	
	header('Content-Type: application/json');
	echo json_encode($resp);

}else{}


function processUser($name, $email, $pass, $extra){
	//name: String - Username of user to be added
	//email: String - Email of user to be added
	//pass: String - Password of the user to be added
	//extra: String - Extra info on who they are 

	$resp = array("CheckUsr" => 0, "CheckEmail" => 0, "CheckPass" => 0);	
	
	// Implement checks from sanitatize.php here
    $usrCheck = sanitizeUser($name,1);
  	$emailCheck = sanitizeEmail($email,1);
	$passCheck = sanitizePass($pass, $name);

	//echo $usrCheck . $emailCheck . $passCheck;

	if($usrCheck && $emailCheck && $passCheck){	 
		
        $filePath = "../../static/AboutUser.txt";
		if (file_exists($filePath) && is_readable($filePath)) {
			
			//Adding to AdboutUser
			$tmpFile = fopen($filePath, "a");
			
        		if ($tmpFile){
                		$fileSize = count(file($filePath));
                		$text = $fileSize+1 . ")" . $name . " " . $email . " " . $extra . "\n"; 
	                	fwrite($tmpFile, $text);
        	        	fclose($tmpFile);
				
					//Add them to the database
					addInfo($name,$email,$pass,0,0);
					$resp = array("CheckUsr" => $usrCheck, "CheckEmail" => $emailCheck, "CheckPass" => $passCheck);
					logs("Successfully added" . $name . "to the list. Waiting to be added\n");
			}
		}
	}
	else{
		$resp = array("CheckUsr" => 0, "CheckEmail" => 0, "CheckPass" => 0);
	}
	return $resp;

}

//processUser("cjkenned","glowstick016@gmail","scooby016!!","etherhe");
?>
