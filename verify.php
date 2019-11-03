<?php
	require_once 'classes/dbh.class.php';
	
	if (isset($_GET['token']))
	{
		$verify = new Dbh();
		$activateError = $verify->verifyEmail($_GET['token']);
		if ($activateError)
		{
			if ($verify->activateAcc($_GET['token']))
			{
				$errorMsg = "You account has been activated. You may now signin!";
				echo $errorMsg;
			}
		}
		else
		{
			$errorMsg = "This account is invalid or already activated!";
			echo $errorMsg;
		}
	}
	else
	{
		$errorMsg = "Something went wrong!";
		echo $errorMsg;
	}
?>
