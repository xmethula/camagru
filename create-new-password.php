<?php
	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';

	if (isset($_POST['reset-password']))
	{
		$validate = new Validate();
		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in all the fields!</li></ul>";
		elseif ($validate->validatePassword($_POST['password']))
			$errMessage = "<ul><li>Password must be between 6 to 16 characters!</li></ul>";
		elseif ($validate->validateConfirm($_POST['password'], $_POST['confirm']))
			$errMessage = "<ul><li>Password do not match!</li></ul>";
	}
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
	<div class="space"></div>

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
