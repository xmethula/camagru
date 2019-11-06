<?php
	session_start();

	if ($_SESSION['userId'])
		header("Location: profile.php");

	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if (isset($_POST['signup-submit']))
	{
		$errMessage = NULL;

		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];

		$validate = new Validate();
		$dbh = new Dbh();

		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in all the fields!</li></ul>";
		elseif ($validate->validateUsername($username))
			$errMessage = "<ul><li>Username must contain only letters and numbers!</li>
							<li>Username must be between 6 to 16 characters!</li></ul>";
		elseif ($validate->validateEamil($email))
			$errMessage = "<ul><li>Email address is invalid!</li></ul>";
		elseif ($validate->validatePassword($password))
			$errMessage = "<ul><li>Password must be between 6 to 16 characters!</li></ul>";
		elseif ($validate->validateConfirm($password, $confirm))
			$errMessage = "<ul><li>Password do not match!</li></ul>";
		elseif ($dbh->existUsername($_POST['username']))
			$errMessage = "<ul><li>Username already exist!</li></ul>";
		elseif ($dbh->existEmail($_POST['email']))
			$errMessage = "<ul><li>email address already exist!</li></ul>";
		elseif ($errMessage == NULL)
		{
			//create a token by hashing a combination of the current time and the email of the user
			$token = password_hash(time() .$email, PASSWORD_DEFAULT);
			$dbh->signupUser($username, $email, $password, $token);

			//send verification email
			$to = $email;
			$subject = "Registration for camagru";
			$message = "<p>Congratulations, you are now registered!!!</br></p>";
			$message .= "<p>Please click on the link below to activate your account:</br></p>";
			$message .= "<p>http://localhost:8080/camagru/verify.php?token=$token</p>";

			$headers = "From: camagru <admin@camagru.co.za>\r\n";
			$headers .= "Reply-To: admin@camagru.co.za\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);

			//display success message
			$errMessage = "<ul><li>Thank you for registering. We have sent a verification e-mail to [ $email ]</li></ul>";

		}
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
	<title>Signup</title>
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

	<?php include_once 'footer.php'; ?>
</body>
</html>
