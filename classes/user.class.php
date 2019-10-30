<?php
	class Users extends Dbh
	{

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
	}
?>
