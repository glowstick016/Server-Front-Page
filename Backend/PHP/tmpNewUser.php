<!DOCTYPE html>
<html>
        <head>
        </head>

<body>
        <h1> Application Form</h1>
                <h2> Requirements </h2>
                        <p>Please include name to make it easier to add (Not saved once admitted)</p>
                        <p>Password needs the following: 10+ Char, 1 Special Char (Include one of the following !#$%^&*_+|:,.?")</p>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Username: <input type="text" name="fName" title="Enter your desired username (No special Chars">
  Email: <input type="email" name="fEmail" title="Enter desired Email">
  Password: <input type="password" name="fPass" title="Enter desired password">
  Extra Info: <input type="text" name="fExtra">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configure file for MySQL change to call a function
        require_once "connect.php";
        require_once "sanitize.php";
        require_once "log.php";

  // collect value of input field
        $name = htmlspecialchars($_POST['fName']);
        $email = htmlspecialchars($_POST['fEmail']);
        $pass = htmlspecialchars($_POST['fPass']);
        $extra = htmlspecialchars($_POST['fExtra']);

        // Implement checks from sanitatize.php here
        $usrCheck = sanitizeUser($name);
        $emailCheck = sanitizeEmail($email);
        $passCheck = sanitizePass($pass, $name);
        if($usrCheck & $emailCheck & $passCheck){
                // Add Salting for password

                $filePath = "../../Issues/AboutUser.txt";
                if (file_exists($filePath) && is_readable($filePath)) {

                        $tmpFile = fopen($filePath, "a");

                        if ($tmpFile){
                                $fileSize = count(file($filePath));
                                $text = $fileSize+1 . ")" .$name . " " . $email . " " . $extra . "\n";
                                fwrite($tmpFile, $text);
                                fclose($tmpFile);

                                logs("Successfully added" . $name . "to the list. Waiting to be added");

                                echo "Successfuly added.You will be reached out to when added or message Cam for assistance" . "\n";

                        }else{echo "Failed to add reach out to Cam";}
                }else{echo "Failed to read file reach out to Cam";}
        }
        else{
                if(!$usrCheck){ echo "Failed Username check, try again";}
                if(!$emailCheck){ echo "Failed Email check, try again";}
                if(!$passCheck){ echo "Failed Password check, try again";}
        }
}
?>
</body>
</html>
