<?php

	if (isset($_POST['action']) && $_POST['action'] == 'logout'){
		//Goal: Break the session for the user 

		session_start();

		$_SESSION = array(); //Unsets
		
		session_destroy();
		echo json_encode(['message' => 'Logged out']);
	}

?>
