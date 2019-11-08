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
						$_SESSION['userId'] = $row['userId'];
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

		public function deleteToken($token)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("UPDATE users SET token=? WHERE token=?");
				$stmt->execute(['', $token]);
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function insertToken($token)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("UPDATE users SET token=?");
				$stmt->execute([$token]);
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function resetPassword($password, $token)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("UPDATE users SET passcode=? WHERE token=?");
				$stmt->execute([$password, $token]);
				if ($stmt->rowCount())
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function gallery($start, $limit)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT imagePath, imageId FROM images ORDER BY postDate DESC LIMIT $start, $limit");
				$stmt->execute();
				$row = $stmt->fetchAll();
				return $row;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function numPages($limit)
		{
			try
				{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT imageId FROM images");
				$stmt->execute();
				$rowCount = $stmt->rowCount();
				$numPages = ceil($rowCount / $limit);
				return $numPages;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function getImage($imageid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT imagePath FROM images WHERE imageId=?");
				$stmt->execute([$imageid]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return $row;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function getComments($imageid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT comment FROM comments WHERE imageId=?");
				$stmt->execute([$imageid]);
				$row = $stmt->fetchAll();
				return $row;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		//insert comment into database
		public function setComment($userid, $imageid, $comment)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("INSERT INTO comments (userId, imageId, comment) VALUE (:userId, :imageId, :comment)");
				$stmt->bindParam(':userId', $userid);
				$stmt->bindParam(':imageId', $imageid);
				$stmt->bindParam(':comment', $comment);
				$stmt->execute();
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		public function getNumComments($imageid)
		{
			try
				{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT commentId FROM comments WHERE imageId=?");
				$stmt->execute([$imageid]);
				$rowCount = $stmt->rowCount();
				return $rowCount;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function getNumLikes($imageid)
		{
			try
				{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT likeId FROM likes WHERE imageId=?");
				$stmt->execute([$imageid]);
				$rowCount = $stmt->rowCount();
				return $rowCount;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		//insert like into database
		public function setLike($userid, $imageid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("INSERT INTO likes (userId, imageId) VALUE (:userId, :imageId)");
				$stmt->bindParam(':userId', $userid);
				$stmt->bindParam(':imageId', $imageid);
				$stmt->execute();
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		// delete like from database
		public function unsetLike($userid, $imageid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("DELETE FROM likes WHERE userId=? AND imageId=?;");
				$stmt->execute([$userid, $imageid]);
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		public function checkLike($userid, $imageid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT userId, imageId FROM likes WHERE userId=? AND imageId=?");
				$stmt->execute([$userid, $imageid]);
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
