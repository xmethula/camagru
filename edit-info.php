<?php
	session_start();

	if (!isset($_SESSION['userId']))
		header("Location: signin.php");


	//include navbar
	include_once 'navbar.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit info</title>
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
		<h2 class="signup-heading">Update Info</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST">
			<input class="signup-input" type="text" name="username" placeholder="username">
			<input class="signup-input" type="text" name="email" placeholder="e-mail address">
			<div>
				<input type="checkbox" class="check-box" name="notify">
				<label class="label-checkbox">Comments Notification</label>
			</div>
			<button class="btn-signup" type="submit" name="signin-submit" value="UPDATE">UPDATE</button>
		</form>
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
