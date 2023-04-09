<?php
	session_start();
?>

<!DOCTYPE html>
<html>
        <head>
                <link rel="stylesheet" href="style.css">
        </head>
        <body>

	<h1>M E T R O</h1>

	<?php 
		// print_r($_SESSION);  USEFUL FOR DEBUGGING

		if($_SESSION["authenticated"])
		{
			print "<p>Please use the following form to upload your file:</p><br>";
			print "<p>This site is part of a school project. Do not upload any important information.</p><br>";

			echo "<p>Signed in as " . $_SESSION["username"].".</p><br>";

			print '<form action="upload.php" method="POST" enctype="multipart/form-data">';
				print '<input type="file" name="fileToUpload" class="button_css" id="uploadedFile">';
				print '<input type="submit" value="Upload Image" class="button_css" name="submit">';
			print '</form>';

			print '<br>';

			$arrFiles = scandir('./uploads');
			$listNum = 0;

			foreach($arrFiles as $file) {
				if($file !== "." && $file !== "..")
				{
					$listNum++;
					echo strval($listNum) .'.   ' . $file .
					' <a href="download.php?file=' . urlencode($file) .
					'"  method="post" >Download</a>' .
					' <a href="delete.php?file=' .
					urlencode($file) . '" method="get" >Delete</a><br>';
				}
			}
		}
		else
		{
			print "<p>Access denied. Please return to homepage and log in.</p><br>";
		}
	?>
        </body>
</html>
