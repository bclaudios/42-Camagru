(function() {
	const width = 800;
	const height = 600;

	let streaming = false;

	let video = null;
	let canvas = null;
	let photo = null;
	let postBtn = null;

	function StartStream()	{
		video = document.getElementById("webcam");
		canvas = document.getElementById("canvas");
		photo = document.getElementById("photo");
		postBtn = document.getElementById("post_btn");

		// Get the webcam stream
		navigator.mediaDevices.getUserMedia({ video: true, audio: false})
			.then(function(stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function(err)	{
				console.log("Error in getUserMedia(): " + err);
			});

		// Set the width/height when the stream is launched
		video.addEventListener('canplay', function(ev)	{
			if (!streaming)	{
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				video.style.transform = 'scaleX(-1)';
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);
		// Button trigger
		postBtn.addEventListener("click", function(ev) {
			stickerSelected = document.getElementById("sticker").firstChild;
			if (stickerSelected.tagName == "IMG")
				TakePicture();
			else
				alert("Please choose a frame before taking a picture.");
			ev.preventDefault();
		}, false);
		ClearPhoto();
	}

	// Clear temporary canvas
	function ClearPhoto()	{
		const context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0,0, canvas.width, canvas.height);
		const data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	function SendPicture(pic, sticker)	{
		const post = "action=createPost"
					+"&img="+pic
					+"&sticker="+sticker
					+"&source=webcam";
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function ()	{
			if (xhr.readyState === 4)	{
				if (xhr.status === 200)
					DisplayPicture(xhr.responseText);
				else
					alert(xhr.responseText);
			}
		}
		xhr.open("POST", "/app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}

	function DisplayPicture(fileName)	{
		const postView = document.getElementById("postView");
		alert("../img/posts/" + fileName);
		photo.setAttribute("src", "app/assets/img/posts/" + fileName);
		const newView = document.createElement("img");
		newView.setAttribute("src", "app/assets/img/posts/" + fileName);
		postView.prepend(newView);
	}

	function TakePicture()	{
		const sticker = document.getElementById("sticker").firstChild.src;
		const context = canvas.getContext('2d');
		context.drawImage(video, 0, 0, width, height);
		const data = canvas.toDataURL('image/png');
		SendPicture(data, sticker);
	}

	window.addEventListener('load', StartStream, false);
})();
