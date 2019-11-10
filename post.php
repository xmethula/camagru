<?php
	session_start();

	if (!isset($_SESSION['userId']))
		header("Location: signin.php");

	$userid = $_SESSION['userId'];
	$errMessage = NULL;

	include_once 'navbar.php';
	require_once 'classes/dbh.class.php';

	if (isset($_POST['upload']))
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
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
			<input class="file-input" type="file" name="file" id="inpFile">

			<div class="post-container">
				<div>
					<div class="image-preview" id="imagePreview">
						<img src="" alt="Image Preview" class="image-preview-image">
						<span class="image-preview-default-text">IMAGE PREVIEW</span>
					</div>

					<div class="stickers">
						<div>
							<img class="sticker" src="assets/images/app/sticker01.png" alt="sticker01">
							<input type="radio" class="radio-btn" name="sticker">
						</div>

						<div>
							<img class="sticker" src="assets/images/app/sticker02.png" alt="sticker02">
							<input type="radio" class="radio-btn" name="sticker">
						</div>

						<div>
							<img class="sticker" src="assets/images/app/sticker03.png" alt="sticker03">
							<input type="radio" class="radio-btn" name="sticker">
						</div>

						<div>
							<img class="sticker" src="assets/images/app/sticker04.png" alt="sticker04">
							<input type="radio" class="radio-btn" name="sticker">
						</div>
					</div>
				</div>

				<div class="uploaded-images">
					<div class="cell-2"></div>
					<div class="cell-2"></div>
					<div class="cell-2"></div>
					<div class="cell-2"></div>
				</div>
			</div>
			<button class="btn-signup" type="submit" name="upload">UPLOAD IMAGE</button>
		</form>
	</div>

	<?php include_once 'footer.php'; ?>

	<script src="assets/js/previewimage.js"></script>
</body>
</html>
