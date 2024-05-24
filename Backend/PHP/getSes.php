<?php

session_start();



if(isset($_SESSION['username'])){

	$tmp = array("auth" => 1, "admin" => $_SESSION['admin']);

}else{ $tmp = array("auth" => 0, "admin" => 0);}

header('Content-Type: application/json');
echo json_encode($tmp);

?>
