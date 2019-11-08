<?php
	include_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Likes  & Comments</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="likes-container">
		<img class="cell" src="assets/images/user/img02.jpeg" alt="">

		<div class="like-comment-num">
			<div class="likes">
				<i class="fa fa-thumbs-o-up"></i>
				<p>24</p>
			</div>
			<div class="comments">
				<p>comments</p>
				<p>2</p>
			</div>
		</div>

		<div class="likes-line"></div>

		<div class="comment-1">
			<img class="likes-profile" src="assets/images/user/img01.jpeg" alt="">
			<div class="comments-block">
				<p>Hi this is a test comment on the camagru web app!</p>
			</div>
		</div>

		<div class="comment-1">
			<img class="likes-profile" src="assets/images/user/img03.jpeg" alt="">
			<div class="comments-block">
				<p>Great work xmethula, Keep pushing till the end!</p>
			</div>
		</div>

		<form action="">
			<div class="comment-1">
				<img class="likes-profile" src="assets/images/user/img04.jpeg" alt="">
				<textarea class="comment-textarea" name="comments" rows="4" placeholder="write a comment"></textarea>
			</div>
			<button class="btn-signup" type="submit" name="comment-submit" value="COMMENT">COMMENT</button>
		</form>
	</div>

	<?php include_once 'footer.php'; ?>
</body>
</html>
