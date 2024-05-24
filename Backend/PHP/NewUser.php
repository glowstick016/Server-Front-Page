<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_POST['action']) && $_POST['action'] == 'newUser') {
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
	$resp = array("CheckUsr" => 0, "CheckEmail" => 0, "CheckPass" => 0);	
	// Implement checks from sanitatize.php here
    	$usrCheck = sanitizeUser($name,1);
  	$emailCheck = sanitizeEmail($email,1);
	$passCheck = sanitizePass($pass, $name);

	//echo $usrCheck . $emailCheck . $passCheck;

	if($usrCheck && $emailCheck && $passCheck){	
		// Add Salting for password 
		//$pass = salty($pass,$name,1);

        	$filePath = "../../static/AboutUser.txt";
		if (file_exists($filePath) && is_readable($filePath)) {
			$tmpFile = fopen($filePath, "a");
			//echo "File found";	
        		if ($tmpFile){
                		$fileSize = count(file($filePath));
                		$text = $fileSize+1 . ")" . $name . " " . $email . " " . $extra . "\n"; 
	                	fwrite($tmpFile, $text);
        	        	fclose($tmpFile);

			//	echo '<div class="success-message">Successfuly added.You will be reached out to when added or message Cam for assistance</div>';
				
				//Add them to the database
				addInfo($name,$email,$pass,0,0);
				$resp = array("CheckUsr" => $usrCheck, "CheckEmail" => $emailCheck, "CheckPass" => $passCheck);
				logs("Successfully added" . $name . "to the list. Waiting to be added\n");
			}//else{echo '<div class="error-message"Failed to add reach out to Cam</div>';}
		}//else{echo '<div class="error-message"Failed to add reach out to Cam</div>';}
	}
	else{
	//	if(!$usrCheck){ echo '<div class="error-message"Failed Username check, try again</div>';}
	//	if(!$emailCheck){ echo '<div class="error-message"Failed Email check, try again</div>';}
	//	if(!$passCheck){ echo '<div class="error-message"Failed Password check, try again</div>';}
	}
	return $resp;

}

//processUser("cjkenned","glowstick016@gmail","scooby016!!","etherhe");
?>
