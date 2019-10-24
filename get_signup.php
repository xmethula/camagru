<?php
	require 'config/database.php';

	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO users (username, mail, pass) VALUES ('xmethula', 'xmethula@student.wethinkcode.co.za', 'QRdb45#!')";
		$conn->exec($sql);
		echo "New record created successfully";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
?>
