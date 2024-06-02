<?php
require_once "connect.php";
require_once "log.php";

function salty($pass, $usr, $new){
	//pass: String - Password that is being converted to a hash 
	//usr: String - User that the password is associated with 
	//new: int - Dictacts if this is for a new user or an old one (1 == new, 0 == old)
	//Goal: Generate a salt of the new inputs, generates new salt for a new user

	$filePath = "../Bash/pass.txt";
	$file = fopen($filePath, "r");
	$salt = trim(fgets($file));
	
	fclose($file);
	//$salty = trim($salt . $pass);
	if( $new === 1){
		$pers = trim(shell_exec("../Bash/salt.sh"));
		$salty = '$6$' . $salt . $pass . $pers;
		$hash = crypt(trim($pass), $salty);
		return array($hash, $pers);
	}else if ($new === 0){
		$pers = getSalt($usr);
		$salty = $salty . $pers;
	}
	$salty = '$6$' . $salt . $pass . $pers;
	$hash = crypt($pass, $salty);

	return $hash;

}

function CheckSeason($usr,$pass){
	//usr: String - Username of the user to be checked
	//pass: String - password to be checked against database hash 

	//Getting Salt
	$hash = salty($pass, $usr, 0);

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
		return false;
	}
}
//$tmp = salty("scooby016!!");
//$tmp = CheckSeason("cjkenned","scooby016!!");
//echo $tmp;
?>
