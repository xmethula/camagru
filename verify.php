<?php
	require_once 'classes/dbh.class.php';

	$errMessage = NULL;

	if (isset($_GET['token']))
	{
		$verify = new Dbh();
		$activateError = $verify->verifyEmail($_GET['token']);
		if ($activateError)
		{
			if ($verify->activateAcc($_GET['token']))
				$errMessage = "<ul><li>You account has been activated. You may now signin!</li></ul>";
			//delete token
			$verify->deleteToken($_GET['token']);
		}
		else
			$errMessage = "<ul><li>This account is invalid or already activated!</li></ul>";
	}
	else
	{
		$errMessage = "<ul><li>Something went wrong!</li></ul>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Account Verification</title>
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

</body>
</html>
