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
				return $conn;
			}
			catch (PDOException $error)
			{
				//echo "Connection failed: " . $error->getMessage();
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
				//echo "Error: " . $error->getMessage();
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
				//echo "Error: " . $error->getMessage();
			}
		}

		//insert user into database
		public function signupUser($username, $email, $password, $token)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("INSERT INTO users (username, email, passcode, token) VALUE (:username, :email, :passcode, :token)");
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':passcode', $password);
				$stmt->bindParam(':token', $token);
				$stmt->execute();
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		public function signinUser($username, $password)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
				$stmt->execute([$username]);
				if ($stmt->rowCount())
				{
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$checkPassword = password_verify($password, $row['passcode']);
					$verified = $row['verified'];
					if ($checkPassword && $verified == 1)
					{
						$_SESSION['userId'] = $row['id'];
						return 2;
					}
					else
					{
						return 1;
					}
				}
				return 0;
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		public function verifyEmail($token)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT token, verified FROM users WHERE token=? AND verified=?");
				$stmt->execute([$token, 0]);
				if ($stmt->rowCount())
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		public function activateAcc($token)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("UPDATE users SET verified=? WHERE token=?");
				$stmt->execute([1, $token]);
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
