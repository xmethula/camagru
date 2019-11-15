<?php
	session_start();

	if (isset($_SESSION['userId']))
		header("Location: profile.php");

	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if(isset($_POST['signin-submit']))
	{
		$errMessage = NULL;

		$username = $_POST['username'];
		$password = $_POST['password'];

		$validate = new Validate();
		$dbh = new Dbh();

		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in all the fields!</li></ul>";
		elseif ($errMessage == NULL)
		{
			$signin = $dbh->signinUser($username, $password);
			if ($signin == 0)
				$errMessage = "<ul><li>Username and password combination does'nt exist!</li></ul>";
			elseif ($signin == 1)
				$errMessage = "<ul><li>Please activate your account!</li></ul>";
			elseif ($signin == 2)
				header("Location: profile.php");
		}
	}
	if (isset($_GET['message']))
	{
		$message = $_GET['message'];
		$errMessage = "<ul><li>$message</li></ul>";
	}

	//include navbar
	include_once 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Signin</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

	<?php if ($errMessage) : ?>
		<div class="err-block">
			<?php echo $errMessage; ?>
		</div>
	<?php endif; ?>

	<div class="signup-wrapper">
		<h2 class="signup-heading">SignIn</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username">
			<input class="signup-input" type="password" name="password" placeholder="password">
			<a class="signup-login" href="signup.php"><p>create an account</p></a>
			<button class="btn-signup" type="submit" name="signin-submit" value="SIGNIN">SIGNIN</button>
			<a class="reset-pass" href="reset-password.php"><p>reset password</p></a>
		</form>
	</div>

	<div class="footer-align-signin">
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
