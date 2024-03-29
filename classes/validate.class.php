<?php
	class Validate {

		public function isEmpty($global_data)
		{
			foreach ($global_data as $data)
			{
				if (empty($data))
					return true;
			}
			return false;
		}

		public function validateUsername($username)
		{
			if (!preg_match('/^[a-zA-Z0-9]{6,16}$/', $username))
				return true;
			return false;
		}

		public function validateEamil($email)
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return true;
			return false;
		}

		public function validatePassword($password)
		{
			if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password))
				return true;
			return false;
		}

		public function validateConfirm($password, $confirm)
		{
			if ($password !== $confirm)
				return true;
			return false;
		}

	}
?>
