<?php
	require'database.php';

	// create database
	try {
		// connect to mySQL server
		$conn = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
		// use exec() because no results are returned
		$conn->exec($sql);
		echo "Database created successfully";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
		exit(-1);
	}
?>
