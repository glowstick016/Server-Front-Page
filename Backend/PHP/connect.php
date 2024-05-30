
<?php
//Include Statements 
require_once "log.php";
require_once "goat.php";

function connect(){
	//Goal: initiate a connection to the database for PHP use

	$DB_SERVER = 'localhost:3306';
	$DB_USERNAME = 'GlowWeb';
	
	$filepath = "../../static/pass.txt";
	$file = fopen($filepath, 'r');
	fget($file);

	$DB_PASSWORD = fget($file);
	fclose($file);

	$DB_NAME = 'GlowWeb';

	/* Attempt to connect to MySQL database */
	$link = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

	// Check connection
	if($link ->connect_error){
		die("ERROR: Could not connect. " . mysqli_connect_error());
		logs("ERROR: Could not connect" . mysqli_connect_error());			
	}
	return $link;
}

function addInfo($username, $email, $pass, $admin, $rights){
	// Username: String - username to be added
	// Email: String - Email to be added
	// Pass: String - Password to be added
	// admin: int - admin rights to be added (0 == Normal)
	// rights: int - Rights to be added (0 == None, 1 == webpage)
	// Goal add the user to 

	list($pass,$salt) = salty($pass,$username,1);

	$link=connect();
	

	//User Info
	$sql=$link->prepare("INSERT INTO Users (Usr, EMAIL, Password, Admin, Rights) values (?,?,?,?,?)");

	//Bind Params
	$sql->bind_param("sssii",$username,$email,$pass,$admin,$rights);
	if($sql->execute()){
		//echo "New user added successfully";
		logs("Added $username waiting approval");
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
		logs("Error: " . $sql . "<br>" . $link->error);
	}

	$link->close();
	addSalt($username,$salt);
}



//Fetching Functions

function getRights($usr){
	//usr: String - Username of the user trying to get rights from
	//Goal: Return the right's 

	$link=connect();

	$sql=$link->prepare("select Rights from Users where Usr = ?");

	if($sql){
		$sql->bind_param("s",$usr);
		$sql->execute();

		$sql->bind_result($tmp);
        	$sql->fetch();
		$sql->close();


        	$rights = $tmp;
		//echo $rights . "\n";
	}else{
		logs("Error getting $usr rights");
		$rights = NULL;
	}
	return $rights;
}

function getAdmin($usr){
	//usr: String - Username of the user trying to get Admin status from
	//Goals: Return the Admin status of user

	$link=connect();

    $sql=$link->prepare("select Admin from Users where Usr = ?");

	if($sql){
        $sql->bind_param("s",$usr);
        $sql->execute();

	    $sql->bind_result($tmp);
		$sql->fetch();
		$sql->close();


        $admin = $tmp;
	
		//echo $admin . "\n";
        return $admin;
	}else{
		logs("Error getting $usr admin status");
		return NULL;
	}
}

function getEmail($usr){
	//$usr - Username of the desired user
	//Goal - return the email of said user

	$link=connect();
	$sql = $link->prepare("select EMAIL from Users where Usr = ? ");

	if($sql){
		$sql->bind_param("s",$usr);
		
		$sql->execute();
		$sql->bind_result($tmp);
		$sql->fetch();
		$sql->close();

		$email = $tmp;
		return $email;
	}else{
		logs("Failed fetching $usr Email");
		return NULL; 
	}
}
//getEmail("cjkenned");

function get2FA($usr){
	//usr: String - Username of the user trying to get the phone number from
	//Goal: Return the Phone number of the desired user

	$link=connect();

	$sql=$link->prepare("select Phone from Users where Usr = ?");

	if($sql){
		$sql->bind_param("s",$usr);

		$sql->execute();
		$sql->bind_result($tmp);
		$sql->fetch();
		$sql->close();

		$phone = $tmp;
		return $phone;
	}else{
		logs("Failed to fetch $usr phone number");
		return NULL;
	}
}

function getSalt($usr){
	//usr: String - Username of the user trying to get salt from
	//Goal: Return the salt of the user

	$link = connect();

	$sql=$link->prepare("select Salt from Users where Usr = ?");


	if($sql){
		$sql->bind_param("s",$usr);

		$sql->execute();
		$sql->bind_result($tmp);
		$sql->fetch();
		$sql->close();
		
		$salt = $tmp;
		return $salt;
	}else{
		logs("Failed to fetch $usr salt");
		return NULL;
	}
}

//Changing Functions

function giveAdmin($usr){
	//usr: String - Username of the user trying to change admin status
	//Goal: Change the user's admin status

	$link=connect();

	$sql=$link->prepare("update Users set Admin = 1 where Usr = ?");

	if($sql){
		$sql->bind_param("s",$usr);

		$sql->execute();
		$sql->close();
		//echo "Added $usr as an admin\n";
		logs("Added $usr as admin");
	}else{
		logs("Error added $usr as admin");
	}
	return;
}

function changeRights($usr, $rights){
	//usr: String - Username of the user trying to change rights
	//Rights: int - Numeric value to represent rights (0 == no rights, 1 == webpage) 
	//Goal : Change the rights value of user

	$link=connect();
	
	$sql=$link->prepare("update Users set Rights = ? where Usr = ?");

	if($sql){
		$sql->bind_param("is", $rights, $usr);

		$sql->execute();
		$sql->close();
		//echo "Change $usr rights to $rights \n";
		logs("Change $usr rights to $rights \n");
	}else{
		logs("Error changing $usr rights");
	}
	return;
}

function changeEmail($usr, $email){
	//usr: String - Username of the user trying to change the Email
	//email: String - Email to be chagned to 
	//Goal: Change the email of the user 

	$link=connect();

	$sql=$link->prepare("update Users set EMAIL = ? where Usr = ?");

	if($sql){
		$sql->bind_param("ss",$email,$usr);

		$sql->execute();
		$sql->close();

		echo "Change $usr email to $email";
		logs("Change $usr email to $email");
	}else{
		logs("Failed to change $usr email to $email");
	}
	return;
}

function changePass($usr, $pass){
	//usr: String - Username of the user trying to change passwords
	//pass: String - Password to be changed to 
	//Goal: Change the user password 

	$hash = salty($pass,$usr,0);
	$link = connect();

	$sql=$link->prepare("update Users set Password = ? where Usr = ?");

	if($sql){
		$sql->bind_param("ss", $hash, $usr);
		
		$sql->execute();
		$sql->close();
		logs("Changed password for $usr");	
	}else{
		logs("failed to change password for $usr");
	}
	return;
}


function change2FA($usr, $phone){
	//usr: String - Username of the user trying to change the phone number
	//phone: String - List of ints that is the user phone number
	//Goal: Change the user's phone number

	$link = connect();

	$sql=$link->prepare("update Users set Phone = ? where Usr = ?");

	if($sql){
		$sql->bind_param("ss",$phone,$usr);

		$sql->execute();
		$sql->close();
		logs("Changed 2FA for $usr");
	}else{
		logs("Failed to change 2FA for $usr");
	}
	return;

}

//Deleting & Adding

function removeUser($usr){
	//usr: String - Username of the user being deleted
	//Goal: Delete the user 

	$link=connect();

	$sql=$link->prepare("delete from Users where Usr = ?");

	if($sql){
		$sql->bind_param("s",$usr);

		$sql->execute();
		$sql->close();
			
	    logs("Removed $usr");
	}else{
		logs("Failed to remove $usr");
	}
	return;
}



function addSalt($usr,$salt){
	//usr: String - Username of the user trying to add a salt
	//salt: String - salt that is being added 
	//Goal: Add a salt to the user database
	
	$link = connect();

	$sql=$link->prepare("update Users set Salt = ? where Usr = ?");

	if($sql){
		$sql->bind_param("ss", $salt, $usr);
		
		$sql->execute();
		$sql->close();
		logs("Added salt for $usr");	
	}else{
		logs("failed to add salt for $usr");
	}
	return;
}



//addInfo("cjkenned","cjkenned@udel.edu","scooby016!!",0,0);
//$usr = "cjkenned";
//addSalt($usr,"a3rjvdsi2i2");
//removeUser($usr);
//changePass($usr,"asa");
?>
