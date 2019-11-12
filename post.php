<?php
	session_start();

	if (!isset($_SESSION['userId']))
		header("Location: signin.php");

	$userid = $_SESSION['userId'];
	$errMessage = NULL;

	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';
	require_once 'classes/image-processing.inc.php';

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
						$dbh = new Dbh();
						$dbh->setImage($userid, $fileNameNew);

						//get the sticker that has been picked
						$image_processing = new ImageProcessing();
						$sticker = $image_processing->getSticker($_POST['sticker']);

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
			<div class="col-row">
				<div class="select-area">
					<select id="dropdown" onchange="setPicture(this)">
						<option value="resources/handtinywhite.gif">select sticker</option>
						<option value="resources/brick.jpg">brick</option>
						<option value="resources/book.png">book</option>
					</select>
					<img class="img1" height="50px" width="50px" src="resources/handtinywhite.gif">
				</div>
				<div>
					<input type="file" name="file">
				</div>
				<button type="submit" name="upload" value="upload image">upload image</button>
			</div>

			<div class="col-row">
				<div class="video-preview-area">
					<div>
						<div class="video-area">
							<video width="100%" id="video" autoplay></video>
						</div>
						<div class="webcam-btn-wrap">
							<!-- When snap button is clicked it takes a snapshot of the video-->
							<button id="snap" class="btn btn-default">Take Snapshot</button>
							<!-- When button is clicked the uploadEx function is called which takes the snapshot and uploads it to the uploads file-->
							<button onclick="uploadEx()" id="new" class="btn btn-default">Save and Upload</button>
							<form method="post" accept-charset="utf-8" name="form1">
								<input name="hidden_data" id="hidden_data" type="hidden">
							</form>

						</div>
					</div>

					<div class="video-area">
						<!-- superposable image on top of the canvas -->

						<!-- Screenshot image is stored in canvas -->
						<canvas id="canvas" style="display:none"></canvas>
						<img src="">
						<img id="test" onclick="change()">
						<img class="img1" height="50px" width="50px" src="resources/handtinywhite.gif">
				</div>
				</div>
			</div>
		<!--</form>-->

		<div class="col-row">
			<p>UPLOADED IMAGES</p>
			<div class="uploaded-images-area">
				<div class="cell-2"></div>
				<div class="cell-2"></div>
				<div class="cell-2"></div>
			</div>
		</div>
	</div>

	<?php include_once 'footer.php'; ?>

	<script src="assets/js/webcam.js"></script>
</body>
</html>
