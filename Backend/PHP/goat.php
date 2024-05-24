<?php
	//Code to salt and unsalt the passwords
require_once "connect.php";
require_once "log.php";

function salty($pass, $usr, $new){
	//Generates a salt of the new inputs, generates new salt for a new user
	//
	$filePath = "../../Data/pass.txt";
	$file = fopen($filePath, "r");
	$salt = fgets($file);
	
	fclose($file);
	$salty = $salt . $pass;
	if( $new === 1){
		$pers = shell_exec("../Bash/salt.sh > /dev/null");
		$hash = crypt($salty, '$2y$10$' . $salt . $pers);
		return array($hash, $pers);
	//	addSalt($usr,$pers);
	}else if ($new === 0){
		$pers = getSalt($usr);
		$salty = $salty . $pers;
	}
	$hash = crypt($salty, '$2y$10$' . $salt . $pers);

	return $hash;
}

function CheckSeason($usr,$pass){
	//Getting Salt
	$hash = salty($pass, $usr, 0);
	//echo "hash was: $hash";
	//Getting user hash
	$link = connect();
	$sql = $link->prepare("select Password from Users where Usr = ?");

	$sql->bind_param("s", $usr);
	$sql->execute();
	$sql->bind_result($tmp);

	$sql->fetch();
	$UsrPass = $tmp;

	$hash = trim($hash);
	$UsrPass = trim($UsrPass);

	//Checking password
	if($hash === $UsrPass){
		logs($usr . ": Successfully verified password");
		return true;
	}else{
		logs($usr . ": Failed password");
		echo "Failed password. Try again\n";
	//	echo $hash . "\n" . $UsrPass . "\n";
		return false;
	}
}
//$tmp = salty("scooby016!!");
//$tmp = CheckSeason("cjkenned","scooby016!!");
//echo $tmp;
?>
