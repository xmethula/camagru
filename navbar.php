<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<nav class="topNavbar">
		<span class="topNavbar-toggle" id="js-topNavbar-toggle">
			<i class="fa fa-reorder"></i>
		</span>
		<a href="gallery.php" class="logo">CAMAGRU</a>
		<ul class="main-nav" id="js-menu">
			<li><a href="gallery.php" class="nav-links">Gallery</a></li>
			<?php if ($_SESSION['userId']) : ?>
				<li><a href="post.php" class="nav-links">Post</a></li>
				<li><a href="profile.php" class="nav-links">Profile</a></li>
				<li><a href="includes/signout.inc.php" class="nav-links">Signout</a></li>
			<?php else : ?>
				<li><a href="signin.php" class="nav-links">Signin</a></li>
				<li><a href="signup.php" class="nav-links">Signup</a></li>
			<?php endif; ?>
		</ul>
	</nav>

	<script src="assets/js/navbar.js"></script>
</body>
</html>
