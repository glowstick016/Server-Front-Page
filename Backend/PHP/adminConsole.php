<?php

require_once 'connect.php';

if (isset($_GET['action']) && $_GET['action'] == 'getAllUsers') {
        //Goal: Display all users in a row allong with buttons for changes 

	$link=connect();

        $sql = $link->prepare("select * from Users");

        if($sql){
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
                                echo "<td><button class='addAdminBtn' data-usr='" . $row["Usr"] . "'>Add Admin</button></td>";
                                echo "<td><button class='addWebRightsBtn' data-usr='" . $row["Usr"] . "'>Give Web Rights</button></td>";
                                echo "<td><button class='removeWebRightsBtn' data-usr='" . $row["Usr"] . "'>Remove Rights</button></td>";
				echo "<td><button class='removeUserBtn' data-usr='" . $row["Usr"] . "'>Remove User</button></td>";
                                echo "</tr>";
                        }
                }
                $sql->close();

        }else{
                logs("failed to pull all users");
        }
}

if (isset($_POST['action']) && $_POST['action'] == 'addAdmin'){
        //Goal: Give admin rights 

	$Usr = $_POST['user'];
	giveAdmin($Usr);
}

if (isset($_POST['action']) && $_POST['action'] == 'addWebRights'){
        //Goal: Change rights to allow for web access 

        $Usr = $_POST['user'];
        changeRights($Usr,1);
}

if (isset($_POST['action']) && $_POST['action'] == 'removeWebRights'){
        //Goal: Change rights to remove web access 

	$Usr = $_POST['user'];
	changeRights($Usr,0);
}

if (isset($_POST['action']) && $_POST['action'] == 'removeUser'){
        //Goal: remove a user 
        
	$usr = $_POST['user'];
	removeUser($usr);
}


?>
