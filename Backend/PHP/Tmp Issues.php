<!DOCTYPE html>
<html>
	<head>
    	//Add check to connect to MySQL (config file) 
    </head>
    
<body>
//Issues
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  User: <input type="text" name="fName">
  Issue: <input type="text" name="fIssue">
  Extra Info: <input type="text" name="fExtra">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configure file for MySQL
  require_once "connect.php";

  // collect value of input field
  $name = htmlspecialchars($_REQUEST['fName']);
  $issue = htmlspecialchars($_REQUEST['fIssue']);
  $spec = htmlspecialchars($_REQUEST['fExtra']);

	// Implement checks here
    //Big end based on SQL length
  	if(strlen($name) > 0 or strlen($name) <= 50){
    } elseif($name == $name){ //Check SQL
    } elseif($name== $name){ //Sanitiation check
    }
    
    if(strlen($issue) > 0 or strlen($email) <= 255){
    } elseif($issue == $issue){ //Sanitiation check
    }
    
    if(strlen($spec) >= 8 or strlen($spec) <= 50){
    }elseif($pass == $pass){ //Sanitiation check
    }
    
    
    //Implement adding to textfile
    $tmpFile = fopen("Issues/../../issues.txt", "a") or die("No file to open");
    $fileSize = count($tmpFile);
    fwrite("\n");
    fwrite($fileSize,")");
    fwrite($name,$issue,$spec);
    
}
?>
</body>
</html>
