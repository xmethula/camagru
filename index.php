<?php
	session_start();

	if (isset($_SESSION['userId']))
		header("Location: profile.php");
	else
		header("Location: signin.php");
?>
