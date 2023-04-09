<?php
	session_start();
	ob_start() or die('Cannot start output buffering'); // Fixes HTML document header being added to start of file data.
?>

<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if(isset($_REQUEST["file"])){
    // Get parameters
	$file = urldecode($_REQUEST["file"]); // Decode URL-encoded string

    /* Check if the file name includes illegal characters
    like "../" using a regular expression */
	if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file))
	{
		$filepath = "uploads/" . $file;

		// Process download
		if(file_exists($filepath))
		{
			ob_end_clean();
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); // Fixes HTML document info being added to start of file data (see line 3).
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			flush(); // Flush system output buffer

			readfile($filepath);

			//LOG TIME File $_REQUEST["file"]["name"] downloaded by User: $_SESSION["username"]
			//Client IP: $CLIENT_IP
			/*
			$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

			fwrite($logfile, date(DATE_COOKIE) . "  File: ". $_REQUEST["file"] .
        			" downloaded by User: " .  $_SESSION["username"] . "  Client IP: " .
				$_SERVER["REMOTE_ADDR"] . "\n");

			fclose($logfile);
			*/
			exit;
		}
		else
		{
		http_response_code(404);
		
		/*
		//LOG TIME File $_REQUEST["file"]["name"] does not exist.
		//User: $_SESSION["username"]  Client IP: $_SERVER["REMOTE_ADDR"]
		$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

		fwrite($logfile, date(DATE_COOKIE) . "  File: ". $_REQUEST["file"] .
				" does not exist. User: " .  $_SESSION["username"] . "  Client IP: " .
			$_SERVER["REMOTE_ADDR"] . "\n");

		fclose($logfile);
		*/

		die();
		}
	}
	else
	{
		/*
		//LOG TIME Invalid filename. User: $_SESSION["username"] client IP: $_SERVER["REMOTE_ADDR"]
		$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

		fwrite($logfile, date(DATE_COOKIE) . "  Invalid filename. User: " .
        		$_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

		fclose($logfile);
		*/

		die("Invalid file name!");
	}
}
?>
</body>
</html>
