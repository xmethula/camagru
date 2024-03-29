<?php
	session_start();

	if (!isset($_SESSION['userId']))
		header("Location: signin.php");

	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';
	require_once 'classes/image-processing.inc.php';

	$userid = $_SESSION['userId'];
	$errMessage = NULL;
	$dbh = new Dbh();

	if (isset($_POST['upload']))
	{
		if (isset($_POST['sticker']))
		{
			$file = $_FILES['file'];

			$fileName = $_FILES['file']['name'];
			$fileTmpName = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileError = $_FILES['file']['error'];
			$fileType = $_FILES['file']['type'];


			$fileExt = explode('.', $fileName);
			$fileActualExt = strtolower(end($fileExt));

			$allowed = array('jpg', 'jpeg', 'png');

			if (in_array($fileActualExt, $allowed))
			{
				if ($fileError === 0)
				{
					if ($fileSize < 500000)
					{
						$fileNameNew = uniqid('', true) . "." . $fileActualExt;
						$fileDestination = 'assets/images/user/' . $fileNameNew;
						move_uploaded_file($fileTmpName, $fileDestination);

						//inssrt image into database
						$dbh->setImage($userid, $fileNameNew);

						$image_processing = new ImageProcessing();
						$sticker = $_POST['sticker'];

						//add sticker and save the image on assets/images/app/
						$image_processing->mergeImages($fileDestination, $sticker);

						$errMessage = "<ul><li>Image uploaded successful!</li></ul>";
					}
					else
						$errMessage = "<ul><li>Image must be less than 5mb!</li></ul>";
				}
				else
					$errMessage = "<ul><li>The was an error uploading your Image!</li></ul>";
			}
			else
				$errMessage = "<ul><li>You cannot upload images of this type!</li></ul>";
		}
		else
			$errMessage = "<ul><li>Please select a sticker!</li></ul>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Post</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

	<?php if ($errMessage) : ?>
		<div class="err-block">
			<?php echo $errMessage; ?>
		</div>
	<?php endif; ?>


	<div class="main-container">
		<!--<form >-->
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
				<div class="col-row">
					<div class="select-area">
						<select class="select-input" name="sticker" id="dropdown" onchange="setPicture(this)">
							<option value="assets/images/app/sticker01.png">sticker01</option>
							<option value="assets/images/app/sticker02.png">sticker02</option>
							<option value="assets/images/app/sticker03.png">sticker03</option>
							<option value="assets/images/app/sticker04.png">sticker04</option>
						</select>
						<img class="img1" height="50px" width="50px" src="assets/images/app/sticker01.png">
					</div>
					<div>
						<input type="file" name="file">
					</div>
					<button class="webcam-btn margin-top-upload" type="submit" name="upload" value="upload image">Upload image</button>
				</div>
			</form>

			<div class="col-row">
				<div class="video-preview-area">
					<div>
						<div class="video-area">
							<video id="video">Stream not available...</video>
						</div>
						<div class="webcam-btn-wrap">
							<button id="photo-button" class="webcam-btn">Capture</button>
							<button onclick="uploadEx()" id="new" class="webcam-btn">Save and upload</button>
							<form method="post" accept-charset="utf-8" name="form1">
								<input name="hidden_data" id="hidden_data" type="hidden">
							</form>
						</div>
					</div>

					<div class="video-area">
						<canvas id="canvas"></canvas>
					</div>
				</div>
			</div>
		<!--</form>-->

		<div class="col-row">
			<p class="uploaded-images-text">UPLOADED IMAGES</p>
			<div class="uploaded-images-area">
				<?php $userImages = $dbh->getUserImages($userid); ?>
				<?php foreach ($userImages as $image) : ?>
					<img class="cell-2" src="assets/images/user/<?php echo $image['imagePath']; ?>" alt="image">
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<?php include_once 'footer.php'; ?>

	<script src="assets/js/webcam.js"></script>
</body>
</html>
