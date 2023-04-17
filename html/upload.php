<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Security-Policy" 
                content="script-src 'self';font-src fonts.gstatic.com;
                style-src 'self' fonts.googleapis.com;img-src 'self';connect-src 'self';
                frame-src 'self'; media-src 'self;object-src 'self';manifest-src 'self';
                prefetch-src 'self';form-action 'self'">
</head>
<body>

<?php
$destination_path = getcwd().DIRECTORY_SEPARATOR;

//Directory file will be uploaded to
$target_dir = "uploads/";

//Specifies path of file to be uploaded
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//Sentinel variable for the final upload action
$uploadOk = 1;

//Holds the lowercase extension of the file
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


//Check if image file is an actual image
if(isset($_POST["submit"])){
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".\n";
		$uploadOk = 1;
	}
	else {
		echo "File is not an image.\n";
		$uploadOk = 0;

		/*
		//LOG $TIME Upload of non-image $_FILES["fileToUpload"] attempted by user: $_SESSION["username"]
		//Client IP: $_SERVER["REMOTE_ADDR"]
		$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

		fwrite($logfile, date(DATE_COOKIE) . "  Upload of non-image: ". $_FILES["fileToUpload"]["name"] .
			" attempted by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

		fclose($logfile);
		*/
	}
}


// Check if file already exists
if (file_exists($target_file)) {
	echo "File already exists in the folder.\n";
	$uploadOk = 0;

	/*
	//LOG TIME Upload of existing file: $_FILES["fileToUpload"]["name"] attempted by User: $_SESSION["username"]
	//Client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Upload of existing file: ". $_FILES["fileToUpload"]["name"] .
        " attempted by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/
}

//Check file size, limit to 500MB (checked as 500 million bytes)
if ($_FILES["fileToUpload"]["size"] > 500000000) {
	echo "File is too large. Please limit uploads to 500MB.\n";
	$uploadOK = 0;
	
	/*
	//LOG TIME Upload of oversized file: $_FILES["fileToUpload"]["name"] attempted by  User: $_SESSION["username"]
	//Client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Upload of oversized file: ". $_FILES["fileToUpload"]["name"] .
        " attempted by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/
}


// Allow common image file types only
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
	echo "Only JPG, JPEG, PNG, and GIF files are supported.\n";
	$uploadOk = 0;

	/*
	//LOG TIME Upload of wrong filetype: $_FILES["fileToUpload"]["name"] attempted by User: $_SESSION["username"]
	//Client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Bad filetype: ". $_FILES["fileToUpload"]["name"] .
        " attempted by User: " .  $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/
}


// Check if $uploadOK was set to 0 indicating upload condition not met
if($uploadOk == 0) {
	echo "Your file was not uploaded.\n";
	
	/*
	//LOG TIME Upload failed. User: $_SESSION["username"] client IP: $_SERVER["REMOTE_ADDR"]
	$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

	fwrite($logfile, date(DATE_COOKIE) . "  Upload failed. User: " .
        $_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

	fclose($logfile);
	*/
}
// if everything OK, try to upload file
else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
		echo "<br><a href='http://ldap.example.com/splash.php'>Return to upload page</a>";
		
		/*
		//LOG TIME File $_FILES["fileToUpload"]["name"] has been uploaded successfully. User:
		//$_SESSION["username"] Client IP: $_SERVER["REMOTE_ADDR"]
		$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

		fwrite($logfile, date(DATE_COOKIE) . "  File: ". $_FILES["fileToUpload"]["name"] .
			" has been uploaded successfully. User: " .  $_SESSION["username"] . "  Client IP: " .
			$_SERVER["REMOTE_ADDR"] . "\n");

		fclose($logfile);
		*/
	}
	else {
		echo "Sorry, there was an error uploading your file.";
		
		/*
		//LOG TIME File checks passed but upload failed. User: $_SESSION["username"] Client IP:
		//$_SERVER["REMOTE_ADDR"]
		$logfile = fopen("/var/log/metro/metro.log", "a") or die("Unable to open log!");

		fwrite($logfile, date(DATE_COOKIE) . "  File checks passed but upload failed. User: " .
        		$_SESSION["username"] . "  Client IP: " . $_SERVER["REMOTE_ADDR"] . "\n");

		fclose($logfile);
		*/
	}
}

?>
</body>
</html>
