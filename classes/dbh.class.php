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
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE username=?");
				$stmt->execute([$username]);
				$count = $stmt->fetchColumn();
				if ($count)
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
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE email=?");
				$stmt->execute([$email]);
				$count = $stmt->fetchColumn();
				if ($count)
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
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE username=?");
				$stmt->execute([$username]);
				$count = $stmt->fetchColumn();
				if ($count)
				{

					$stmt = $conn->prepare("SELECT userId, passcode, verified FROM users WHERE username=?");
					$stmt->execute([$username]);
					$row = $stmt->fetch(PDO::FETCH_ASSOC);

					$checkPassword = password_verify($password, $row['passcode']);
					$verified = $row['verified'];
					if ($checkPassword && $verified == 1)
					{
						$_SESSION['userId'] = $row['userId'];
						return 2;
					}
					elseif (!$checkPassword && $verified == 1)
					{
						return 0;
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
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE token=? AND verified=?");
				$stmt->execute([$token, 0]);
				$count = $stmt->fetchColumn();
				if ($count)
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
				$count = $stmt->rowCount();
				if ($count)
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
				$count = $stmt->rowCount();
				if ($count)
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
				$stmt = $conn->prepare("SELECT count(*) FROM images");
				$stmt->execute();
				$count = $stmt->fetchColumn();
				$numPages = ceil($count / $limit);
				return $numPages;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		//insert image into database
		public function setImage($userid, $imagePath)
		{
			try
			{
				$conn = $this->connect();
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

		public function getUserImages($userid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT imagePath FROM images WHERE userId=? ORDER BY postDate DESC");
				$stmt->execute([$userid]);
				$row = $stmt->fetchAll();
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
				$stmt = $conn->prepare("SELECT count(*) FROM comments WHERE imageId=?");
				$stmt->execute([$imageid]);
				$count = $stmt->fetchColumn();
				return $count;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		public function sendCommentEmail($imageid)
		{
			try
				{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT userId FROM images WHERE imageId=?");
				$stmt->execute([$imageid]);
				$id = $stmt->fetch(PDO::FETCH_ASSOC);

				$stmt = $conn->prepare("SELECT email, commentNotify FROM users WHERE userId=?");
				$stmt->execute([$id['userId']]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return $row;
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
				$stmt = $conn->prepare("SELECT count(*) FROM likes WHERE imageId=?");
				$stmt->execute([$imageid]);
				$count = $stmt->fetchColumn();
				return $count;
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
				$stmt = $conn->prepare("SELECT count(*) FROM likes WHERE userId=? AND imageId=?");
				$stmt->execute([$userid, $imageid]);
				$count = $stmt->fetchColumn();
				if ($count)
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		// get username, email, commentNotify, imagePath, num-of-images, num-of-likes
		public function getUserInfo($userid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT username, email, commentNotify FROM users WHERE userId=?");
				$stmt->execute([$userid]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				$stmt = $conn->prepare("SELECT imagePath FROM images WHERE userId=? ORDER BY postDate DESC LIMIT 1");
				$stmt->execute([$userid]);
				$image = $stmt->fetch(PDO::FETCH_ASSOC);

				$stmt = $conn->prepare("SELECT count(*) FROM images WHERE userId=?");
				$stmt->execute([$userid]);
				$imageNum = $stmt->fetchColumn();

				$stmt = $conn->prepare("SELECT count(*) FROM likes WHERE userId=?");
				$stmt->execute([$userid]);
				$likeNum = $stmt->fetchColumn();

				$row['imagePath'] = $image['imagePath'];
				$row['imageNum'] = $imageNum;
				$row['likeNum'] = $likeNum;

				return $row;
			}
			catch (PDOException $error)
			{
				echo "Error: " . $error->getMessage();
			}
		}

		//checks if username exist and belongs to the signed in users
		public function existUsernameUpdate($username, $userid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE username=? AND userId!=?");
				$stmt->execute([$username, $userid]);
				$count = $stmt->fetchColumn();
				if ($count)
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		//checks if email exist and belongs to the signed in users
		public function existEmailUpdate($email, $userid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT count(*) FROM users WHERE email=? AND userId!=?");
				$stmt->execute([$email, $userid]);
				$count = $stmt->fetchColumn();
				if ($count)
					return true;
				return false;
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

		// update user info in database
		public function updateUserInfo($username, $email, $notify, $userid)
		{
			try
			{
				$conn = $this->connect();
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("UPDATE users SET username=?, email=?, commentNotify=? WHERE userId=?");
				$stmt->execute([$username, $email, $notify, $userid]);
			}
			catch (PDOException $error)
			{
				//echo "Error: " . $error->getMessage();
			}
		}

	}
?>
