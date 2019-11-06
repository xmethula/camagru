<?php
	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Gallery</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<h2 class="signup-heading">Gallery</h2>
	<div class="gallery-container">
		<?php
			$dbh = new Dbh();
			$images = $dbh->gallery();
			$i = 0;
		?>
		<?php while ($i < count($images)) : ?>
			<div>
				<img class="well" src="assets/images/user/<?php echo $images[$i] ?>" alt="image">
			</div>
			<?php $i++; ?>
		<?php endwhile; ?>
	</div>
	<ul class="pager">
		<li><a href="#">«</a></li>
		<li><a href="#">1</a></li>
		<li class="pager-active"><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">...</a></li>
		<li><a href="#">45</a></li>
		<li><a href="#">»</a></li>
	</ul>

	<?php include_once 'footer.php'; ?>
</body>
</html>

