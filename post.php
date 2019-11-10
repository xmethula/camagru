<?php
	include_once 'navbar.php';
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

	<div class="main-container">
		<form action="">
			<input class="file-input" type="file" name="inpFile" id="inpFile">

			<div class="post-container">
				<div class="image-preview" id="imagePreview">
					<img src="" alt="Image Preview" class="image-preview-image">
					<span class="image-preview-default-text">IMAGE PREVIEW</span>
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
