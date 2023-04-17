<?php
        session_start();
        require_once 'classes/Token.php';
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
                <h1>M E T R O</h1>
		<br>

		<form action="auth.php" method="post">
                        <input type="text" name="username" placeholder="Username"/><br>
                        <input type="password" name="password" placeholder="Password" /><br><br>
                        <input type="submit" value="Login" />
                        <input type="hidden" name="_csrf_token" value="<?php echo Token::generate(); ?>">
                </form>
        </body>
</html>
<?php
//echo "<br>".$_SESSION['_csrf_token'];
?>
