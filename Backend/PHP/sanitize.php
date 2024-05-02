<?php
//Include Statements
require_once 'connect.php';
require_once 'log.php';


//Add error returns


function sanitizeUser($usr, $new){
        $tmp = false;

        //Checking base requirements
        if(strlen($usr) > 0 or strlen($usr) <= 50){
                $info = trim($usr);
                $info2 = stripslashes($usr);
                $info3 = htmlspecialchars($usr);


                //Check for Special chars & other checks
                if($usr == $info & $usr == $info2 & $usr == $info3){

                        $specChar = "/[!@#$%^&*()_+{}[\]\|;:'\"<>,.?\/]/";
                        if(preg_match($specChar, $usr)){
                                $tmp = false;
                                logs($usr . " failed the sanitization check");
                        }else{$tmp=true;}
                }
        }else{ echo "Username didn't fit inside the size boundaries";}

        //Check SQL databse for non duplicate for new user
        if ($new === 1){

                if($tmp === true){

                        //Quearying database for duplicate check
                        $link = connect();
                        $query = "select * from Users where Usr = ?";
                        $state = $link->prepare($query);
                        $state->bind_param("s", $usr);
                        $state->execute();
                        $res= $state->get_result();

                        //Checking results
                        if ($res->num_rows > 0) {
                                $tmp = false;
                                echo "Bad username";
                                logs($usr . " tried to make a duplicate account");
                        }

                }
        }
        return $tmp;
}

function sanitizeEmail($email,$new){
        $tmp = false;
        if(strlen($email) > 0 or strlen($email) <= 255){
                $info = trim($email);
                $info2 = stripslashes($email);
                $info3 = htmlspecialchars($email);

                if( $email == $info & $email == $info2 & $email == $info3){
                        $specChar = "/[!#$%^&*()_+{}[\]\|;:'\"<>,.?\/]/";
                        if(preg_match($specChar, $email)){
                                $tmp = false;
                                logs($email . " failed the sanitization check");
                        }else{$tmp = true;}
        }else{ echo "Email didn't fit inside the size boundaries";}
        }
        //Check SQL database for non duplicate for new user
        if ($new === 1){

                if($tmp === true){

                        //Querying database
                        $link = connect();
                        $query = "select * from Users where EMAIL = ?";
                        $state = $link->prepare($query);
                        $state = bind_param("s",$email);
                        $state->execute();
                        $res = $state->get_result();

                        //Checking results
                        if ($res->num_rows > 0){
                                $tmp = false;
                                logs( $email . " tried to make a duplicate account");
                        }
                }
        }
        return $tmp;
}

function sanitizePass($pass, $usr){
        $tmp = false;
        if(strlen($pass) >= 10 or strlen($pass) <= 50){
                $info = trim($pass);
                $info2 = stripslashes($pass);
                $info3 = htmlspecialchars($pass);

                if( $pass == $info & $pass == $info2 & $pass == $info3){
                        $specChar = "!#$%^&*_+|:,.?";
                        if(preg_match($specChar,$pass)){
                                $tmp = true;
                        }else{
                                echo "Password didn't have a special character";
                                logs( $usr . ": password didn't pass sanitization");
                        }
                }
        }else{ echo "Password didn't fit inside the size boundaries";}
        return $tmp;
}


sanitizeUser("cjkenned",1);
?>
