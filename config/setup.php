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
			userId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			username VARCHAR(50) UNIQUE NOT NULL,
			email VARCHAR(50) UNIQUE NOT NULL,
			passcode VARCHAR(255) NOT NULL,
			token VARCHAR(255) NOT NULL,
			verified INT(1) NOT NULL DEFAULT 0,
			commentNotify INT(1) NOT NULL DEFAULT 1,
			registerDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)";
		$conn->exec($sql);
		echo "Table users created successfully<br>";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	// create table images
	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS images (
			imageId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			userId INT(11) NOT NULL,
			imagePath VARCHAR(255) NOT NULL,
			postDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)";
		$conn->exec($sql);
		echo "Table images created successfully<br>";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}


	// create table comments
	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS comments (
			commentId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			userId INT(11) NOT NULL,
			imageId INT(11) NOT NULL,
			comment VARCHAR(255) NOT NULL,
			commentDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)";
		$conn->exec($sql);
		echo "Table comments created successfully<br>";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}


	// create table likes
	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS likes (
			likeId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			userId INT(11) NOT NULL,
			imageId INT(11) NOT NULL,
			likeDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)";
		$conn->exec($sql);
		echo "Table likes created successfully<br>";
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}


	// insert 1 user into database
	$username = "xmethula";
	$email = "xmethula@gmail.com";
	$password = "QRdb45#!";
	$password = password_hash($password, PASSWORD_DEFAULT);
	$token = "";
	$verified = 1;
	try
	{
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("INSERT INTO users (username, email, passcode, token, verified) VALUE (:username, :email, :passcode, :token, :verified)");
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':passcode', $password);
		$stmt->bindParam(':token', $token);
		$stmt->bindParam(':verified', $verified);
		$stmt->execute();
		echo "Default user inserted successfully<br>";
	}
	catch (PDOException $error)
	{
		echo "Error: " . $error->getMessage();
	}


	// insert 12 images for the above user
	for ($i = 1; $i <= 12; $i++)
	{
		$userid = 1;
		$imagePath = "default" .$i .".png";
		try
		{
			$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("INSERT INTO images (userId, imagePath) VALUE (:userId, :imagePath)");
			$stmt->bindParam(':userId', $userid);
			$stmt->bindParam(':imagePath', $imagePath);
			$stmt->execute();
		}
		catch (PDOException $error)
		{
			//echo "Error: " . $error->getMessage();
		}
	}
	echo "Default images inserted successfully<br>";

	header("Location: ../gallery.php");
?>
