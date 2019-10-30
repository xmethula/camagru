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
		echo "Database $DB_NAME created successfully" . "<br>";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
		die(-1);
	}

	// create table users
	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS users (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			username VARCHAR(50) UNIQUE NOT NULL,
			email VARCHAR(50) UNIQUE NOT NULL,
			`password` VARCHAR(255) NOT NULL,
			verified INT(1) NOT NULL DEFAULT 0
		)";
		$conn->exec($sql);
		echo "Table users created successfully\n";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
?>
