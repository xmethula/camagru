<?php
	require '../config/database.php';

	class Dbh {
		public function connect() {
			try {
				$conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo "Connected to database successfully!";
				return $conn;
			}
			catch (PDOException $error)
			{
				echo "Connection failed: " . $error->getMessage();
				exit();
			}
		}
	}
?>
