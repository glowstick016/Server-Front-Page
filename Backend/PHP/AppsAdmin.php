<?php

if (isset($_GET['action']) && $_GET['action'] == 'dispChecks'){
        //Goal: Display all the system checks for admins 

	$path = "../../static/ipA";
	$file = fopen($path, 'r');
	$filesize = count(file($path));


	echo '<div class="status-grid">';
	for ($i = 0; $i < $filesize; $i++){
                $line = fgets($file);
        	$tmp = explode(':',$line);

        	$host = $tmp[0];
        	$port = $tmp[1];
        	$application = $tmp[2];
        	$command = "nmap -p $port $host | grep open";
        	$tmp = shell_exec($command);
		if ($tmp) {
			echo '<div class="status-item">';
			echo "<p> $application</p>";
			echo "<img class='checkmark' src='../../Pictures/check.jpg' alt='Checkmark'>";
			echo "</div>";

		}else{
			echo '<div class="status-item">';
                        echo "<p>$application</p>";
                        echo "<img class='x' src='../../Pictures/x.jpg' alt='X'>";
                        echo "</div>";	
		}
	}
	echo '</div>';


        fclose($file);
}

if (isset($_GET['action']) && $_GET['action'] == 'dispApps'){
        //Goal: Disaply all the Admin apps 

        $path = "../../static/AppsAdmin.txt";
        $file = fopen($path, 'r');
        $filesize = count(file($path));

        echo '<div class="apps-grid">';
        for ($i = 0; $i < $filesize; $i++){
                $line = fgets($file);
                $tmp = explode('~',$line);
                if ($tmp){
                        echo '<div class="app-button">';
                        $name = trim($tmp[0]);
                        $link = trim($tmp[1],'"');
                        $target = trim($tmp[2],'"');
                        $pic = trim($tmp[3],'"');
                        $desc = trim($tmp[4],'"');
                        echo "<h2> $name </h2><br>";
                        echo "<a href='$link' target='$target'><img src='$pic' alt='$desc'></a>";
                        echo "</div>";

                }

        }
        echo "</div>";
        fclose($file);
}


?>
