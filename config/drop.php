<?php
	require 'database.php';

	// drop database
	try {
		$conn = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DROP DATABASE $DB_NAME";
		$conn->exec($sql);
		echo "Database droped successfully";
	}
	catch (PDOException $e)
	{
		$sql . "<br>" . $e->getMessage();
		die(-1);
	}
?>
