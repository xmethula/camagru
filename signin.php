<?php
	session_start();

	if ($_SESSION['userId'])
		header("Location: index.php");

	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if(isset($_POST['signin-submit']))
	{
		$validate = new Validate();
		$empty = $validate->isEmpty($_POST);

		if ($empty == false)
		{
			$check = new Dbh();
			$signin = $check->signinUser($_POST['username'], $_POST['password']);
			if ($signin)
				header("Location: profile.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Signin</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="space"></div>

	<?php if (isset($_POST['signin-submit'])) : ?>
		<?php if ($empty) : ?><!--error block-->
			<div class="err-block">
				<ul><li>Please fill in all the fields!</li></ul>
			</div>

		<?php elseif ($signin == false) : ?>
			<div class="err-block">
				<ul><li>Username and password combination does'nt exist!</li></ul>
			</div>
		<?php endif ?>
	<?php endif; ?>

	<div class="signup-wrapper">
		<h2 class="signup-heading">SignIn</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username">
			<input class="signup-input" type="password" name="password" placeholder="password">
			<a class="signup-login" href="signup.php"><p>create an account</p></a>
			<button class="btn-signup" type="submit" name="signin-submit" value="SIGNIN">SIGNIN</button>
			<a class="reset-pass" href="resetpassword.php"><p>reset password</p></a>
		</form>
	</div>
</body>
</html>
