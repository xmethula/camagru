<?php
	require_once './config/database.php';

	class Dbh
	{
		public function connect()
		{
			try
			{
				$conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//echo "Connected to database successfully!";
				return $conn;
			}
			catch (PDOException $error)
			{
				echo "Connection failed: " . $error->getMessage();
				exit();
			}
		}

		//checks if username exist in database
		public function existUsername($username)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
				$stmt->execute([$username]);
				if ($stmt->rowCount())
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		//checks if email exist in database
		public function existEmail($email)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
				$stmt->execute([$email]);
				if ($stmt->rowCount())
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}
	}
?>
