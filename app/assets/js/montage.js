(function() {
	const width = 800;
	const height = 600;

	let streaming = false;

	let video = null;
	let canvas = null;
	let photo = null;
	let startButton = null;

	function StartStream()	{
		video = document.getElementById("video");
		canvas = document.getElementById("canvas");
		photo = document.getElementById("photo");
		startButton = document.getElementById("startButton");

		// Get the webcam stream
		navigator.mediaDevices.getUserMedia({ video: true, audio: false})
			.then(function(stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function(err)	{
				console.log("Error in getUserMedia(): " + err);
			});

		// Set the width/height when de stream is launched
		video.addEventListener('canplay', function(ev)	{
			if (!streaming)	{
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		startButton.addEventListener("click", function(ev) {
			TakePicture();
			ev.preventDefault();
		}, false);
		ClearPhoto();
	}

	function ClearPhoto()	{
		const context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0,0, canvas.width, canvas.height);

		const data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	function SendPicture(pic)	{
		console.log(pic);
		const post = "action=createPost"
					+"&img="+pic;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function ()	{
			if (xhr.readyState === 4)	{
				alert(xhr.responseText);
			}
		}
		xhr.open("POST", "/app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}

	function TakePicture()	{
		const context = canvas.getContext('2d');
		context.drawImage(video, 0, 0, width, height);
		const data = canvas.toDataURL('image/png');
		SendPicture(data);
		photo.setAttribute('src', data);
	}

	window.addEventListener('load', StartStream, false);
})();
