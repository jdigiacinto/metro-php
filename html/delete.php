<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$filepath = './uploads/';

$filename = $filepath . $_GET['file'];

if(!unlink($filename))
{
	echo "Deletion failed";

	/*
	//LOG TIME Deletion of File: $_GET['file']["name"] failed by User: $_SESSION["username"]
	//Client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Deletion of File: ". $_GET['file'] .
        	"  failed by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/

}
else
{
	echo "Deletion successful";
	echo "<br><a href='http://ldap.example.com/splash.php'>Return to upload page</a>";
	
	/*
	//LOG TIME Deletion of File: $_GET['file']["name"] successful by User: $_SESSION["username"]
	//Client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Deletion of File: ". $_GET['file'] .
        "  successful by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/

}


?>
</body>
</html>
