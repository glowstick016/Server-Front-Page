<?php>

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configure file for MySQL change to call a function

        require_once "connect.php";
        require_once "sanitize.php";
        require_once "log.php";
        require_once "goat.php";

        $name = $_POST['fName'];
        $issue = $_POST['fIssue'];


        $resp = processIssue($name, $issue);

        header('Content-Type: application/json');
        echo json_encode($resp);

}else{}


?>

