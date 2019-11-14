<?php
	session_start();

	if (!isset($_SESSION['userId']))
		header("Location: signin.php");

	require_once 'classes/dbh.class.php';
	include_once 'navbar.php';

	$userid = $_SESSION['userId'];

	$dbh = new Dbh();
	$info = $dbh->getUserInfo($userid);

	//dispaly success message from update info page
	if (isset($_GET['message']))
	{
		$message = $_GET['message'];
		$errMessage = "<ul><li>$message</li></ul>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Profile</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

	<?php if ($errMessage) : ?>
		<div class="err-block">
			<?php echo $errMessage; ?>
		</div>
	<?php endif; ?>


	<div class="profile-wrapper">
		<?php if (isset($info['imagePath'])): ?>
			<img class="profile-img" src="assets/images/user/<?php echo $info['imagePath']; ?>" alt="image">
		<?php else : ?>
			<div class="profile-img"></div>
		<?php endif; ?>
		<h3 class="username"><?php echo $info['username']; ?></h3>
		<p class="email"><?php echo $info['email']; ?></p>
		<div class="line-1"></div>
		<div class="statistics">
			<div class="posts">
				<p class="num"><?php echo $info['imageNum']; ?></p>
				<p class="text">POSTS</p>
			</div>
			<div class="likes">
				<p class="num"><?php echo $info['likeNum']; ?></p>
				<p class="text">LIKES</p>
			</div>
		</div>
		<div class="line-2"></div>
		<?php
			if ($info['commentNotify'] == 1)
				$notify = "True";
			else
				$notify = "False";
		?>
		<p class="active-date">Comments notification: <?php echo $notify; ?></p>
		<a href="edit-info.php"><div class="btn-personal">EDIT INFO</div></a>
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
