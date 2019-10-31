<?php
	session_start();

	if ($_SESSION['userId'])
		echo "SignedIn" . "<br>";
	else
		echo "SignedOut" . "<br>";
?>
