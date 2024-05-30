<?php

require_once 'connect.php';
require_once 'sanitize.php';
require_once 'goat.php';


if (isset($_GET['action']) && $_GET['action'] == 'getUser') {
        //Goal: Build up the userprofile page to display all the buttons and settings 

	//Getting the username
	session_start();
	$name = $_SESSION['username'];

        $link=connect();

        $sql = $link->prepare("select * from Users where Usr = ?");

        if($sql){
		$sql->bind_param('s',$name);
                $sql->execute();
                $res = $sql->get_result();
                if( $res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>" . $row["Usr"] . "</td>";
                                echo "<td>" . $row["EMAIL"] . "</td>";
                                echo "<td>" . $row["Rights"] . "</td>";
                                echo "<td>" . $row["Admin"] . "</td>";
                                echo "<td>" . $row["Phone"] . "</td>";
                                echo "<td><button id = 'changePass' class='changePassword' data-usr='" . $row["Usr"] . "'>Change Password</button></td>";
                                echo "<td><button id = 'changeFA' class='change2FA' data-usr='" . $row["Usr"] . "'>Change 2FA Numbers</button></td>";
                                echo "<td><button id = 'changeEml' class='changeEmail' data-usr='" . $row["Usr"] . "'>Change Email</button></td>";
                                echo "</tr>";
                        }
                }
                $sql->close();

        }else{
                logs("failed to pull all users");
        }
}

if (isset($_POST['action']) && $_POST['action'] == 'changePass'){
        //Goal: Change the user's password 

	$oldPass = $_POST['oldPass'];
	$newPass = $_POST['newPass'];
	$checkPass = $_POST['checkPass'];

	session_start();
	$usr = $_SESSION['username'];
	if( $newPass == $checkPass){ 
		if (sanitizePass($newPass, $usr)){
		       	if ($newPass == $checkPass){
				changePass($usr,$newPass);	
				echo "Password changed";
			}else{ echo "Password's didn't match";}
		}else{ echo "Passowrd failed sanitization";}
	}else{echo "Reach out to Cam or make a ticket";}


}

if (isset($_POST['action']) && $_POST['action'] == 'changeEmail'){
        //Goal: Change the user's email 

        $newEmail = $_POST['newEmail'];

        session_start();
        $usr = $_SESSION['username'];
        if($usr){
		if(sanitizeEmail($newEmail)){
                	changeEmail($usr,$newEmail);
                	echo "Email Changed";
		}else{"Email didn't pass sanitization";}
        }else{echo "Reach out to Cam or make a ticket";}


}


if (isset($_POST['action']) && $_POST['action'] == 'changePhone'){
        //Goal: Change the user's phone number

        $res = sanitizePhone($_POST['newPhone']);

        session_start();
        $usr = $_SESSION['username'];
	if($usr){
		if($res['valid'] === 'true'){
                	change2FA($usr,$res['number']);
                	echo "Phone number changed Changed";
		} else{ echo "Phone didn't pass sanitization";}
        }else{echo "Nope";}


}

?>
