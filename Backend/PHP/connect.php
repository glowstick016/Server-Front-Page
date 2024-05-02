<?php
//Include Statements
require_once "log.php";


function addInfo($username, $email, $pass, $admin){
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
        $DB_SERVER = 'localhost:3306';
        $DB_USERNAME = 'GlowWeb';
        $DB_PASSWORD = 'JbLr+KSswbEpo1FF';
        $DB_NAME = 'GlowWeb';

        /* Attempt to connect to MySQL database */
        $link = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

        // Check connection
        if($link ->connect_error){
                die("ERROR: Could not connect. " . mysqli_connect_error());
                logs("ERROR: Could not connect" . mysqli_connect_error());
        }

        //User Info

        $sql = "INSERT INTO Users (Usr, EMAIL, Password, Admin) VALUES ('$username', '$email', '$pass', '$admin')";

        //Checking if it worked
        if ($link->query($sql) === TRUE) {
                echo "New user added successfully";
        } else {
                echo "Error: " . $sql . "<br>" . $link->error;
                logs("Error: " . $sql . "<br>" . $link->error);
        }

        $link->close();
}

function connect(){
                $DB_SERVER = 'localhost:3306';
                $DB_USERNAME = 'GlowWeb';
                $DB_PASSWORD = 'JbLr+KSswbEpo1FF';
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

?>
