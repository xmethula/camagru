// Global Vars
let width = 400,
    height = 0,
    filter = 'none',
    streaming = false;

// DOM Elements
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photoButton = document.getElementById('photo-button');
const img1 = document.querySelector('.img1');

// Get media stream
navigator.mediaDevices.getUserMedia({video: true, audio: false})
  .then(function(stream) {
    // Link to the video source
    video.srcObject = stream;
    // Play video
    video.play();
  })
  .catch(function(err) {
    console.log(`Error: ${err}`);
  });

  // Play when ready
  video.addEventListener('canplay', function(e) {
    if(!streaming) {
      // Set video / canvas height
      height = video.videoHeight / (video.videoWidth / width);

      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);

      streaming = true;
    }
  }, false);

  // Photo button event
  photoButton.addEventListener('click', function(e) {
    takePicture();

    e.preventDefault();
  }, false);


  function setPicture(select){
    var DD = document.getElementById('dropdown');
    var value = DD.options[DD.selectedIndex].value;
    img1.src = value;

  }

  // Take picture from canvas
  function takePicture() {
    // Create canvas
    const context = canvas.getContext('2d');
    if(width && height) {
      // set canvas props
      canvas.width = width;
      canvas.height = height;
      // Draw an image of the video on the canvas
      context.drawImage(video, 0, 0, width, height);
      context.drawImage(img1, 50, 50, 150, 150);
    }
  }

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
