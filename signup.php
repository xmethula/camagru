<?php
	session_start();

	if ($_SESSION['userId'])
		header("Location: profile.php");

	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if (isset($_POST['signup-submit']))
	{
		$validate = new Validate();
		$empty = $validate->isEmpty($_POST);
		$username = $validate->validateUsername($_POST['username']);
		$email = $validate->validateEamil($_POST['email']);
		$password = $validate->validatePassword($_POST['password']);
		$confirm = $validate->validateConfirm($_POST['password'], $_POST['confirm']);

		$ifExist = new Dbh();
		$existUsername = $ifExist->existUsername($_POST['username']);
		$existEmail = $ifExist->existEmail($_POST['email']);
		if ($empty == false && $username == false && $email == false && $password == false &&
			$confirm == false && $existUsername == false && $existEmail == false)
		{
			//create a token by hashing a combination of the current time and the email of the user
			$token = password_hash(time() .$_POST['email'], PASSWORD_DEFAULT);
			$ifExist->signupUser($_POST['username'], $_POST['email'], $_POST['password'], $token);

			//send verification email and redirect to thank you page
			$to = $_POST['email'];
			$subject = "Email verification";
			$message = " Congratulations, you are now registered!!

			Please click on the link below to activate your account

			http://localhost:8080/camagru/verify.php?token=$token";
			$headers = "From: admin@camagru.co.za \r\n";
			mail($to, $subject, $message, $headers);
			header("Location: thankyou.php");
		}
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


	<?php if (isset($_POST['signup-submit'])) : ?>
		<?php if ($empty) : ?><!--error block-->
			<div class="err-block">
				<ul><li>Please fill in all the fields!</li></ul>
			</div>

		<?php elseif ($username) : ?>
			<div class="err-block">
				<ul><li>Username must contain only letters and numbers!</li></ul>
				<ul><li>Username must be between 6 to 16 characters!</li></ul>
			</div>

		<?php elseif ($email) : ?>
			<div class="err-block">
				<ul><li>Email address is invalid!</li></ul>
			</div>

		<?php elseif ($password) : ?>
			<div class="err-block">
				<ul><li>Password must be between 6 to 16 characters!</li></ul>
			</div>

		<?php elseif ($confirm) : ?>
			<div class="err-block">
				<ul><li>Password do not match!</li></ul>
			</div>

		<?php elseif ($existUsername) : ?>
			<div class="err-block">
				<ul><li>Username already exist!</li></ul>
			</div>

		<?php elseif ($existEmail) : ?>
			<div class="err-block">
				<ul><li>email address already exist!</li></ul>
			</div>
		<?php endif; ?><!--end error block-->
	<?php endif; ?>


	<div class="signup-wrapper">
		<h2 class="signup-heading">SignUp</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username" value="<?php echo htmlspecialchars($_POST['username']) ?? '' ?>">
			<input class="signup-input" type="text" name="email" placeholder="email-address" value="<?php echo htmlspecialchars($_POST['email']) ?? '' ?>">
			<input class="signup-input" type="password" name="password" placeholder="password">
			<input class="signup-input" type="password" name="confirm" placeholder="confirm password">
			<a class="signup-login" href="signin.php"><p>already have an account?</p></a>
			<button class="btn-signup" type="submit" name="signup-submit" value="SIGNUP">SIGNUP</button>
		</form>
	</div>
</body>
</html>
