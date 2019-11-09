<?php
	session_start();

	if (!isset($_SESSION['userId']))
	{
		header("Location: signin.php");
	}

	include_once 'navbar.php';
	require_once 'classes/validate.class.php';
	require_once 'classes/dbh.class.php';
	
	$userid = $_SESSION['userId'];
	
	$dbh = new Dbh();
	$info = $dbh->getUserInfo($userid);

	if (isset($_POST['update-submit']))
	{
		$errMessage = NULL;

		$username = $_POST['username'];
		$email = $_POST['email'];
		$notify = $_POST['notify'];

		$validate = new Validate();

		if ($validate->isEmpty($_POST))
			$errMessage = "<ul><li>Please fill in all the fields!</li></ul>";
		elseif ($validate->validateUsername($username))
			$errMessage = "<ul><li>Username must contain only letters and numbers!</li>
							<li>Username must be between 6 to 16 characters!</li></ul>";
		elseif ($validate->validateEamil($email))
			$errMessage = "<ul><li>Email address is invalid!</li></ul>";
		elseif ($dbh->existUsernameUpdate($username, $userid))
			$errMessage = "<ul><li>Username already exist!</li></ul>";
		elseif ($dbh->existEmailUpdate($email, $userid))
			$errMessage = "<ul><li>email address already exist!</li></ul>";
		elseif ($errMessage == NULL)
		{	
			//set comments notification value
			if ($notify == "on")
			{
				$notify = 1;
			}
			else
			{
				$notify = 0;
			}

			//update user info in database
			$dbh->updateUserInfo($username, $email, $notify, $userid);
			//success message
			$errMessage = "You info has been updated successfully!";
			header("Location: profile.php?message=$errMessage");
		}
	}
	
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
			<input class="signup-input" type="text" name="username" placeholder="username" value="<?php if (isset($_POST['update-submit']))  echo $_POST['username'];  else echo $info['username']; ?>">
			<input class="signup-input" type="text" name="email" placeholder="e-mail address" value="<?php if (isset($_POST['update-submit']))  echo $_POST['email'];  else echo $info['email']; ?>">
			<div>
				<?php if ($info['commentNotify'] == 1) : ?>
					<input type="checkbox" class="check-box" name="notify" checked>
				<?php else : ?>
					<input type="checkbox" class="check-box" name="notify">
				<?php endif; ?>
				<label class="label-checkbox">Comments Notification</label>
			</div>
			<button class="btn-signup" type="submit" name="update-submit" value="UPDATE">UPDATE</button>
		</form>
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
