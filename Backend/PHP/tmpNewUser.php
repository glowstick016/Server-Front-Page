<!DOCTYPE html>
<html>
	<head>
    	//Basically should just add to NewUser and make an php file
    </head>
    
<body>
//New user
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="fName">
  Email: <input type="email" name="fEmail">
  Password: <input type="text" name="fPass">
  Extra Info: <input type="text" name="fExtra">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configure file for MySQL
  require_once "connect.php";

  // collect value of input field
  $name = htmlspecialchars($_REQUEST['fName']);
  $email = htmlspecialchars($_REQUEST['fEmail']);
  $pass = htmlspecialchars($_REQUEST['fPass']);
  $extra = htmlspecialchars($_REQUEST['FExtra']);

	// Implement checks here
    //Big end based on SQL length
  	if(strlen($name) > 0 or strlen($name) <= 50){
    } elseif($name == $name){ //Check SQL
    } elseif($name== $name){ //Sanitiation check
    }
    
    if(strlen($email) > 0 or strlen($email) <= 255){
    } elseif($email == $email){ //Check SQL
    } elseif($email == $email){ //Sanitiation check
    }
    
    if(strlen($pass) >= 8 or strlen($pass) <= 50){
    } elseif($pass == $pass){ //Check SQL
    } elseif($pass == $pass){ //Sanitiation check
    }
    
    if(strlen($extra) > 0 or strlen($extra) <= 50){
    } elseif($extra == $extra){ //Check SQL
    } elseif($extra == $extra){ //Sanitiation check
    }
    
    //Implement adding to SQL
    
    //Add extra to txt file or smth w/ username
    $tmpFile = fopen("Issues/../../AboutUser.txt", "a") or die("No file to open");
    $fileSize = count($tmpFile);
    fwrite("\n");
    fwrite($fileSize,")");
    fwrite($name,$email,$extra);
}
?>
</body>
</html>
