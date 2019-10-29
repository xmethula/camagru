<?php
	class Validate {

		private $username;
		private $email;
		private $password;
		private $confirm;

		public function __construct($username, $email, $password, $confirm) {
			$this->username = $username;
			$this->email = $email;
			$this->password = $password;
			$this->confirm = $confirm;
		}

		public function empty() {
			if (empty($this->username) || empty($this->email) || empty($this->password) || empty($this->confirm))
				header("Location: ../signup.php?error=empty&username=$this->username&email=$this->email");
		}

		public function valUsername() {
			if (!preg_match("/^[a-zA-Z]*$/", $this->username) || (strlen($this->username) < 6) || (strlen($this->username) > 15))
				header("Location: ../signup.php?error=username&email=$this->email");
		}

		public function valEmail() {
			if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
				header("Location: ../signup.php?error=email&username=$this->username");
		}

		public function valPassword() {
			if (strlen($this->password) < 6 || strlen($this->password) > 16)
				header("Location: ../signup.php?error=password&username=$this->username&email=$this->email");
		}

		public function valConfirm() {
			if ($this->password !== $this->confirm)
				header("Location: ../signup.php?error=confirm&username=$this->username&email=$this->email");
		}
	}
?>
