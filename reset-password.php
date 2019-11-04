<?php
	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if (isset($_POST['send-mail']))
	{
		$errMessage = NULL;
		$email = $_POST['email'];

		$validate = new Validate();
		$dbh = new Dbh();

		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in the e-mail field!</li></ul>";
		elseif ($validate->validateEamil($email))
			$errMessage = "<ul><li>Email address is invalid!</li></ul>";
		elseif ($dbh->existEmail($email) === false)
			$errMessage = "<ul><li>Email address does not exist!</li></ul>";
		elseif ($errMessage == NULL)
		{
			//create a token by hashing a combination of the current time and the email of the user
			$token = password_hash(time() .$email, PASSWORD_DEFAULT);
			$dbh->insertToken($token);

			//send email containing link to reset password
			$to = $email;
			$subject = "Reset your password for camagru";
			$message = "<p>We received a password reset request. The link to reset your password is below if you did not</p>";
			$message .= "<p>make this request, you can ignor this email. Here is your password reset link: </br></p>";
			$message .= "<p>http://localhost:8080/camagru/create-new-password.php?token=$token</p>";

			$headers = "From: camagru <admin@camagru.co.za>\r\n";
			$headers .= "Reply-To: admin@camagru.co.za\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);
			
			//succes message
			$errMessage = "<ul><li>We have sent an e-amil containing a link to reset your password to [ $email ]</li></ul>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset Password</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="space"></div>

	<?php if ($errMessage) : ?>
		<div class="err-block">
			<?php echo $errMessage; ?>
		</div>
	<?php endif; ?>

	<div class="signup-wrapper">
		<h2 class="signup-heading">Reset Your Password</h2>
		<p class="reset-pass">An e-mail will be sent to you with instructions on how to reset your password.</p>
		<form action="" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="email" placeholder="Enter your e-mail address" value="<?php echo htmlspecialchars($_POST['email']) ?? '' ?>">
			<button class="btn-signup reset-btn" type="submit" name="send-mail" value="SEND MAIL">SEND MAIL</button>
		</form>
	</div>
</body>
</html>
