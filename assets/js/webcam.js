/*Object is used when calling getUserMedia() to specify what kinds of tracks is needed with the video stream.
Optionally, to add constraints such as video and audio. */
const constraints = {
	video:true,
	audio:false
}


const video = document.querySelector("#video");
//getUserMedia method prompts the user for permission to use a media input which produces, in this case, a video stream.
navigator.mediaDevices.getUserMedia(constraints).then((stream) => {video.srcObject = stream});
const screenShotButton = document.querySelector('#snap');
const img = document.querySelector("img");
const img1 = document.querySelector('.img1');



//this function is called above with the selection of superposable images. Depending on which option you selected it takes the value and adds it to the image src.
function setPicture(select){
	var DD = document.getElementById('dropdown');
	var value = DD.options[DD.selectedIndex].value;
	img1.src = value;

}


//when the screenshot button is clicked a canvas image is created from the video feed and img1 is added on the top
screenShotButton.onclick = video.onclick = function(){
	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;
	var context = canvas.getContext('2d');

	context.globalAlpha = 1.0;
	context.drawImage(video, 0, 0);
	context.globalAlpha = 1.0;
	context.drawImage(img1, 59, 92);
	// toDataUrl method returns a data URI containing a representation of the image in the format specified by the type.
	//In this case the format is png
	img.src = canvas.toDataURL('image/png');
};
function handleSuccess(stream) {
	screenShotButton.disabled = false;
	video.srcObject = stream;
}
var url = canvas.toDataURL();


//Function uses ajax to send image data to upload_data.php
function uploadEx(){
	var dataURL = canvas.toDataURL("image/png");
	document.getElementById('hidden_data').value = dataURL;
	var fd = new FormData(document.forms["form1"]);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'upload_data.php', true);

	xhr.upload.onprogress = function(e){
		if (e.lengthComputable) {
			var percentComplete = (e.loaded /e.total) * 100;
			console.log(percentComplete + '% uploaded');
			alert('Succesfully uploaded');
		}
	};
	xhr.send(fd);
}
