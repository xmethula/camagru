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

	<div class="signup-wrapper">
		<h2 class="signup-heading">SignIn</h2>
		<form action="get_signin.php" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username">
			<input class="signup-input" type="password" name="password" placeholder="password">
			<a class="signup-login" href="signup.php"><p>create an account</p></a>
			<button class="btn-signup" type="submit" name="signup-submit">SIGNIN</button>
			<a class="reset-pass" href="resetpassword.php"><p>reset password</p></a>
		</form>
	</div>
</body>
</html>
