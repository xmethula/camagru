<?php
	session_start();

	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';

	if (!isset($_GET['imageid']))
		header("Location: gallery.php");

	$imageid = $_GET['imageid'];

	$dbh = new Dbh();
	//get image from images table
	$image = $dbh->getImage($imageid);

	$errMessage = NULL;

	if (isset($_POST['like-submit']))
	{
		if (!isset($_SESSION['userId']))
			$errMessage = "<ul><li>You need to signin in order to like a post!</li></ul>";
		else
		{
			$userid = $_SESSION['userId'];

			$checklike = $dbh->checkLike($userid, $imageid);
			if ($checklike)
			{
				$dbh->unsetLike($userid, $imageid);
				$errMessage = "<ul><li>You dislike was submitted successfully!</li></ul>";
			}
			else
			{
				$dbh->setLike($userid, $imageid);
				$errMessage = "<ul><li>You like was submitted successfully!</li></ul>";
			}


		}
	}
	elseif (isset($_POST['comment-submit']))
	{
		if (!isset($_SESSION['userId']))
			$errMessage = "<ul><li>You need to signin in order to comment on a post!</li></ul>";
		else
		{
			$userid = $_SESSION['userId'];
			$usercomment = strip_tags($_POST['comment']);
			$setComment = $dbh->setComment($userid, $imageid, $usercomment);

			$commentEmail = $dbh->sendCommentEmail($imageid);
			if ($commentEmail['commentNotify'] == 1)
			{
				//send comment email
				$to = $commentEmail['email'];
				$subject = "New comment for your post";
				$message = "<p>You have recieved a new comment!!!</br></p>";
				$message .= "<p>Please click on the link below to see the comment:</br></p>";
				$message .= "<p>http://localhost:8080/camagru/comments.php?imageid=$imageid</p>";

				$headers = "From: camagru <notification@camagru.co.za>\r\n";
				$headers .= "Reply-To: admin@camagru.co.za\r\n";
				$headers .= "Content-type: text/html\r\n";

				mail($to, $subject, $message, $headers);
			}

			$errMessage = "<ul><li>You comment was submitted successfully!</li></ul>";
		}

	}

	// get number of likes from comments table
	$numlikes = $dbh->getNumLikes($imageid);


	// get number of comments from comments table
	$numcomments = $dbh->getNumComments($imageid);
	// get comments from comments table
	$comments = $dbh->getComments($imageid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Comments</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

	<?php if ($errMessage) : ?>
		<div class="err-block">
			<?php echo $errMessage; ?>
		</div>
	<?php endif; ?>

	<div class="comments-container">
		<img class="cell" src="assets/images/user/<?php echo $image['imagePath']; ?>" alt="">

		<div class="comments-row">
			<div class="comments-col">
				<i class="fa fa-thumbs-o-up"></i>
				<p><?php echo $numlikes; ?></p>
			</div>

			<div class="comments-col">
				<i class="fa fa-comment-o"></i>
				<p><?php echo $numcomments; ?></p>
			</div>
		</div>

		<div class="comments-line"></div>

		<?php foreach ($comments as $comment) : ?>
			<div class="comment-wrap">
				<img class="comment-profile" src="assets/images/app/sticker01.png" alt="">
				<div class="comment-box">
					<p><?php echo $comment['comment']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="comment-wrap">
			<?php if (isset($_SESSION['userId'])) : ?><!-- hide profile pic if not loged in -->
				<img class="comment-profile" src="assets/images/user/img05.jpeg" alt="">
			<?php endif; ?>
			<form action="" method="POST">
				<?php if (isset($_SESSION['userId'])) : ?><!-- hide comment box if not loged in -->
					<textarea class="comment-textarea" name="comment" rows="3" placeholder="write your comment"></textarea>
				<?php endif; ?>

				<div class="comments-row">
					<button class="like-btn" type="submit" name="like-submit">
						<div class="comments-col">
							<i class="fa fa-thumbs-o-up"></i>
							<p>LIKE</p>
						</div>
					</button>

					<button class="like-btn" type="submit" name="comment-submit">
						<div class="comments-col">
							<i class="fa fa-comment-o"></i>
							<p>COMMENT</p>
						</div>
					</button>
				</div>
			</form>
		</div>
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
