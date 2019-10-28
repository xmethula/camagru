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

	<div class="signup-wrapper">
		<h2 class="signup-heading">Reset</h2>
		<form action="get_resetpassword.php" autocomplete="off" method="POST">
			<input class="signup-input" type="email" name="email" placeholder="email-address">
			<button class="btn-signup" type="submit" name="signup-submit">RESET</button>
		</form>
	</div>
</body>
</html>
