<?php
	if (isset($_POST['signup-submit']))
	{
		include '../classes/validate.class.php';

		$username = new validate();
		$username->valUsername($_POST['username']);
	}
	else
	{
		header("Location: ../signup.php");
	}
?>
