<?php
	if (isset($_POST['signup-submit']))
	{
		include '../classes/validate.class.php';
		include '../classes/dbh.class.php';

		$obj = new Validate($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm']);

		$obj->valConfirm();
		$obj->valPassword();
		$obj->valEmail();
		$obj->valUsername();
		$obj->empty();

		$conn = new Dbh;
		$conn->connect();
	}
	else
	{
		header("Location: ../signup.php");
	}
?>
