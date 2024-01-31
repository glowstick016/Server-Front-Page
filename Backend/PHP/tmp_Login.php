<!DOCTYPE html>
<html>
	<head>
    	//Add check to connect to MySQL (config file) 
    </head>
    
<body>
//New user
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="fName">
  Email: <input type="email" name="fEmail">
  Password: <input type="text" name="fPass">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configure file for MySQL
  require_once "connect.php";

  // collect value of input field
  $name = htmlspecialchars($_REQUEST['fName']);
  $email = htmlspecialchars($_REQUEST['fEmail']);
  $pass = htmlspecialchars($_REQUEST['fPass']);

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
    
    
    //Implement adding to SQL
    
    //Add extra to txt file or smth w/ username
}
?>
</body>
</html>
