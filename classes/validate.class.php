<?php
	class Validate {

		public function valUsername($username){
			if (!preg_match("/^[a-zA-Z]*$/", $username) || (strlen($username) < 6) || (strlen($username) > 15))
				header("Location: ../signup.php?error=username");
		}
	}
?>
