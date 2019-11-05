<?php
	session_start();

	if ($_SESSION['userId'])
		header("Location: profile.php");

	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	$token = $_GET['token'];

	if (isset($_POST['reset-password']))
	{
		$errMessage = NULL;
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];

		$validate = new Validate();
		$dbh = new Dbh();

		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in all the fields!</li></ul>";
		elseif ($validate->validatePassword($password))
			$errMessage = "<ul><li>Password must be between 6 to 16 characters!</li></ul>";
		elseif ($validate->validateConfirm($password, $confirm))
			$errMessage = "<ul><li>Password do not match!</li></ul>";
		elseif ($errMessage == NULL)
		{
			if ($dbh->resetPassword($password, $token))
				$errMessage = "<ul><li>Your password has been reset successfully!</li></ul>";
			else
				$errMessage = "<ul><li>An error has occured!</li></ul>";
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
	<title>Create New Password</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
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
		<h2 class="signup-heading">Enter New Password</h2>
		<form action="" autocomplete="off" method="POST">
			<input class="signup-input" type="password" name="password" placeholder="Enter new password">
			<input class="signup-input" type="password" name="confirm" placeholder="Repeat new password">
			<button class="btn-signup reset-btn" type="submit" name="reset-password" value="RESET PASSWORD">RESET PASSWORD</button>
		</form>
	</div>
</body>
</html>
