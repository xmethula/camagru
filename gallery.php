<?php
	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';

	$limit = 3;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$start = ($page - 1) * $limit;

	$dbh = new Dbh();
	$images = $dbh->gallery($start, $limit);
	$pages = $dbh->numPages($limit);

	//previous pager
	if ($page == 1)
		$prev = $page;
	else
		$prev = $page - 1;

	//next pager
	if ($page == $pages)
		$next = $page;
	else
		$next = $page + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Gallery</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<h2 class="signup-heading">Gallery</h2>
	<div class="gallery-container">
		<?php foreach ($images as $image) : ?>
			<div>
				<a href="comments.php?imageid=<?php echo $image['imageId'] ?>"><img class="well" src="assets/images/user/<?php echo $image['imagePath'] ?>" alt="image"></a>
			</div>
		<?php endforeach; ?>
	</div>
	<ul class="pager">
		<li><a href="gallery.php?page=<?php echo $prev; ?>">«</a></li>
		<?php $i = 1; ?>
		<?php while ($i <= $pages) : ?>
			<li><a href="gallery.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
			<?php $i++; ?>
		<?php endwhile; ?>
		<li><a href="gallery.php?page=<?php echo $next; ?>">»</a></li>
	</ul>

	<?php include_once 'footer.php'; ?>
</body>
</html>

