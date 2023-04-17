<?php
session_start();
require_once 'classes/Token.php';

if(isset($_POST['username'], $_POST['password'], $_POST['_csrf_token'])) {
	
	$ldapuser = $_POST['username'];
	$ldappass = $_POST['password'];

	if(!empty($ldapuser) && !empty($ldappass)) {
		//if(Token::check($_POST['_csrf_token'])) {
		//echo "Session:  ".$_SESSION['_csrf_token']."<br>";
		//echo "Post:  ".$_POST['_csrf_token']."<br>";

		if(isset($_SESSION['_csrf_token']) && $_POST['_csrf_token'] == $_SESSION['_csrf_token']) {
			echo "ok<br>";
		}
		else {
			echo "check failed<br>";
			exit;
		}
	}
}

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
$ldaphost = "ldap://ldap.example.com:389";
$ldapconn = ldap_connect($ldaphost) or die("Failed to connect");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

if($ldapconn)
{
	//User input of username (uid) and password
	$ldapuser = $_POST["username"];
	$ldappass = $_POST["password"];

	//LDAP will bind to an empty uid and password so we have to check:
	if(!empty($ldapuser) && !empty($ldappass))
	{
		//Search for person that corresponds to the uid, get their info as array and get their dn from that array.
		$userinfo = ldap_search($ldapconn, "ou=people,dc=example,dc=com", "(uid=".$ldapuser.")")
											or exit("Invalid UID.");

		$userarray = ldap_get_entries($ldapconn, $userinfo);

		$userdn = $userarray[0]["dn"];

		//Attempt binding to ldap server using the user's dn and password.
		$ldapbind = ldap_bind($ldapconn, $userdn, $ldappass);

		if($ldapbind)
		{
			echo "LDAP bind successful.";
			//LOG SPOT ex: LDAP bind successful at $TIME by client $CLIENT_IP with uid: $ldapuser and password:

			$_SESSION["userinfo"] = $userarray;
			$_SESSION["authenticated"] = true;
			$_SESSION["username"] = $ldapuser;

			if($_SESSION["authenticated"])
			{
				//print "<br>";
				//echo "User $ldapuser authenticated.";
				//print "<br>";
				//echo "Redirecting...";
				header("Location: http://ldap.example.com/splash.php") or die("Redirect failed");
			}
		}
		else
		{
			session_unset();
			session_destroy();
			echo "LDAP bind failed.";
			//LOG SPOT ex: LDAP bind failed at $TIME by client $CLIENT_IP with supplied credentials
			//uid: $ldapuser and password: $ldappass
		}
	}
	else
	{
		session_unset();
		session_destroy();
		echo "Invalid username or password.";
		//LOG SPOT Empty uid and/or password supplied: uid: $ldapuser password: $ldappass
	}
}
?>
</body>
</html>
