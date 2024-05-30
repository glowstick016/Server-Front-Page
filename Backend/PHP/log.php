<?php

function logs($msg){
	//msg: String - the message that is being added to the log system 
	//Goal: Add to a log file in a usable format 

	$filePath = "../../logs.log";
	$tmpFile = fopen($filePath, "a");
	if($tmpFile === false){
		die("Unable to open file");
	}else{
		$txt = date('Y-m-d H:i:s') . ": $msg \n";
		fwrite($tmpFile, $txt);
		fclose($tmpFile);
	}
 
}

?>
