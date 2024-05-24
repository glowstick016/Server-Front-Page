<?php

function logs($msg){
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
