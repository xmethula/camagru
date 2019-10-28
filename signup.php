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
	<?php	if (isset($_GET['error'])) : ?>
		<?php $errMessage = $_GET['error']; ?>
			<?php if ($errMessage == "username") : ?>
				<div class="err-block">
					<ul><li>Username must contain only letters and numbers!</li></ul>
					<ul><li>Username must contain a minimum of 3 characters!</li></ul>
					<ul><li>Username must contain a maximum of 16 characters!</li></ul>
				</div>
			<?php endif; ?>
	<?php endif; ?>


	<div class="signup-wrapper">
		<h2 class="signup-heading">SignUp</h2>
		<form action="includes/signup.inc.php" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username">
			<input class="signup-input" type="email" name="email" placeholder="email-address">
			<input class="signup-input" type="password" name="password" placeholder="password">
			<input class="signup-input" type="password" name="confirm" placeholder="confirm password">
			<a class="signup-login" href="signin.php"><p>already have an account?</p></a>
			<button class="btn-signup" type="submit" name="signup-submit">SIGNUP</button>
		</form>
	</div>
</body>
</html>
