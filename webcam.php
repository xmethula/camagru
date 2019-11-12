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

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<!-- Live video image-->
				<video id="video" autoplay></video>
				<!-- When snap button is clicked it takes a snapshot of the video-->
				<button id="snap" class="btn btn-default">Take Snapshot</button>
				<!-- When button is clicked the uploadEx function is called which takes the snapshot and uploads it to the uploads file-->
				<button onclick="uploadEx()" id="new" class="btn btn-default">Save and Upload</button>
				<form method="post" accept-charset="utf-8" name="form1">
					<input name="hidden_data" id="hidden_data" type="hidden">
				</form>
				<!-- superposable image on top of the canvas -->
				<img src="">
				<!-- Screenshot image is stored in canvas -->
				<canvas id="canvas" style="display:none"></canvas>
				<img onclick="change()">
		</div>

			<div class="col-md-4">

				<!-- Selection of superposable image -->
				<!-- Options to select an image that is used on top of your webcam image. I've used an extremely tiny gif for the
				the default image(handtinywhite.gif). When you select an option (onchange) the image source will change to option you
				have selected which will change the below img as well as add the src to your second canvas image below.
				-->
				<img class="img1" height="200" width="300" src="resources/handtinywhite.gif">
				<select id="dropdown" onchange="setPicture(this)">
					<option value="resources/handtinywhite.gif">Non</option>
					<option value="resources/brick.jpg">brick</option>
					<option value="resources/book.png">book</option>
					<option value="resources/arrow.png">arrow</option>
					<option value="resources/reload.png">reload</option>
					<option value="resources/chat-icon.png">chat</option>
					<option value="resources/towel.png">towel</option>
					<option value="resources/oeil.png">oeil</option>
					<option value="resources/loupe.png">loupe</option>
				</select>
			</div>
		</div>
	</div>


	<script src="assets/js/webcam.js"></script>
</body>
</html>
