<?php
	require 'classes/validate.class.php';

	if (isset($_POST['signup-submit']))
	{
		$validate = new UserValidator();
		$username = $validate->validateUsername($_POST['username']);
		$email = $validate->validateEamil($_POST['email']);
		$password = $validate->validatePassword($_POST['password']);
		$confirm = $validate->validateConfirm($_POST['password'], $_POST['confirm']);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Signup</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="space"></div>



	<?php if ($username) : ?><!--error block-->
		<div class="err-block">
			<ul><li>Username must contain only letters and numbers!</li></ul>
			<ul><li>Username must be between 6 to 16 characters!</li></ul>
		</div>
	<?php endif; ?>

	<?php if ($email) : ?>
		<div class="err-block">
			<ul><li>Email address is invalid!</li></ul>
		</div>
	<?php endif; ?>

	<?php if ($password) : ?>
		<div class="err-block">
			<ul><li>Password must be between 6 to 16 characters!</li></ul>
		</div>
	<?php endif; ?>

	<?php if ($confirm) : ?>
		<div class="err-block">
			<ul><li>Password do not match!</li></ul>
		</div>
	<?php endif; ?><!--end error block-->



	<div class="signup-wrapper">
		<h2 class="signup-heading">SignUp</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username" required value="<?php echo htmlspecialchars($_POST['username']) ?? '' ?>">
			<input class="signup-input" type="email" name="email" placeholder="email-address" required value="<?php echo htmlspecialchars($_POST['email']) ?? '' ?>">
			<input class="signup-input" type="password" name="password" placeholder="password" required>
			<input class="signup-input" type="password" name="confirm" placeholder="confirm password" required>
			<a class="signup-login" href="signin.php"><p>already have an account?</p></a>
			<button class="btn-signup" type="submit"  name="signup-submit">SIGNUP</button>
		</form>
	</div>
</body>
</html>
