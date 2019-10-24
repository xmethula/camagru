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
	<div class="space"></div>

				<form class="sign-form" action="get_signup.php" method="POST">
					<div class="form-group">
						<input class="form-control" type="text" name="username" placeholder="username">
					</div>
					<div class="form-group">
						<input class="form-control" type="email" name="mail" placeholder="email-address">
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="pass" placeholder="password">
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="confirm_pass" placeholder="confirm password">
					</div>
					<button type="submit" class="btn btn-primary">SIGNUP</button>
				</form>

</body>
</html>
