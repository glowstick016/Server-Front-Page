<?php
//Include Statements
require_once 'connect.php';
require_once 'log.php';


//Add error returns


function sanitizeUser($usr, $new){
	//usr: String - Username being checked
	//new: int - variable to determine if new or not (0 == new)
	//Goal: Check if the username passes all the checks

	$tmp = false;

	//Checking base requirements
	if(strlen($usr) > 0 or strlen($usr) <= 50){
		$info = trim($usr);
		$info2 = stripslashes($usr);
		$info3 = htmlspecialchars($usr);
		
		//Check for Special chars & other checks
		if($usr == $info & $usr == $info2 & $usr == $info3){ 
	
			$specChar = '/[!@#$%^&*()_+{}[\]\|;:\'\"<>,.?\/]/';
			if(preg_match($specChar, $usr)){
				$tmp = false;
				logs($usr . " failed the sanitization check");
			}else{$tmp=true;}
		}
	}

	//Check SQL databse for non duplicate for new user
	if ($new === 1){

		if($tmp === true){

			//Quearying database for duplicate check
			$link = connect();
			$query = "select count(*) from Users where Usr = ?";
			$state = $link->prepare($query);

			$state->bind_param("s", $usr);
			$state->execute();
			$state->bind_result($count);
			
			$state->fetch();
			//Checking results
			if ($count > 0) {
				$tmp = false;
				//echo "Bad username";
				logs($usr . " tried to make a duplicate account");
			}

		}
	}
	return $tmp;
}

function sanitizeEmail($email,$new){
	//email: String - email to be checked
	//new: int - variable to determin if the email is new or not (0 == new)
	//Goal: Find out if the email passes the sanitization checks 

	$tmp = false;

	//Checking size requires for database
	if(strlen($email) > 0 or strlen($email) <= 255){
		$info = trim($email);
		$info2 = stripslashes($email);
		$info3 = htmlspecialchars($email);
	
		//Check for Special chars & other checks
		if( $email == $info & $email == $info2 & $email == $info3){
			$specChar = '/[!#$%^&*()_+{}[\]\|;:\'\"<>,?\/]/';
			if(preg_match($specChar, $email)){
				$tmp = false;
				logs($email . " failed the sanitization check");
			}else{$tmp = true;}
		}

	}
	//Check SQL database for non duplicate for new user
	if ($new === 1){
		
		if($tmp === true){
			
			//Querying database
			$link = connect();
			$query = "select * from Users where EMAIL = ?";
			$state = $link->prepare($query);
			$state->bind_param("s",$email);
			$state->execute();
			$res = $state->get_result();

			//Checking results
			if ($res->num_rows > 0){
				$tmp = false;
				logs( $email . " tried to make a duplicate account");
			}
		}
	}
	return $tmp;
}

function sanitizePass($pass, $usr){
	//pass: String - password to be checked 
	//Goal: Check the user's password to meet the requirements 

	$tmp = false;
	//Check length & if it has a special char 
	if(strlen($pass) >= 10 or strlen($pass) <= 255){
		$specChar = '#[!$%^&*_+|:,.?]#';
		if(preg_match($specChar,$pass)){
			$tmp = true;
		}else{ 
			logs( $usr . ": password didn't pass sanitization");
		}
	}
	return $tmp;
}

function sanitizePhone($phone){
	//phone: String - phone number to be converted
	//Goal: converting the phone number into desired format and making sure it's valid 
	$number = preg_replace('/[^0-9]/', '', $phone);
	if(strlen($number) === 10){
		$tmp = array("number" => $number, "valid" => "true");
	} else { $tmp = array("number" => NULL, "valid" => "false");}
	return $tmp;
}

//sanitizeUser("cjkenned",1);
?>
