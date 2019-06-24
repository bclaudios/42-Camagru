(function() {
	const width = 800;
	const height = 600;

	let streaming = false;

	let video = null;
	let canvas = null;
	let postBtn = null;

	function StartStream()	{
		video = document.getElementById("webcam");
		canvas = document.getElementById("canvas");
		postBtn = document.getElementById("post-btn");
		webcamCard = document.getElementById("webcam-card");
		
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
				webcamCard.hidden = false;
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
			stickerSelected = document.getElementById("sticker");
			if (stickerSelected.firstChild)
			CreatePost();
			else
			DisplayNotif("montage-ui", "Please, select a sticker before taking a picture.");
			ev.preventDefault();
		}, false);
	}
	
	function SendPicture(pic, sticker)	{
		const token = document.getElementById("token").value;
		const post = "action=createPost"
					+"&token="+token
					+"&img="+pic
					+"&sticker="+sticker
					+"&source=webcam";
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function ()	{
			if (xhr.readyState === 4)	{
				if (xhr.status === 200)
					DisplayPost(xhr.responseText);
				else
					alert(xhr.responseText);
			}
		}
		xhr.open("POST", "/app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}

	function DisplayPost(JSONpost)	{
		const post = JSON.parse(JSONpost)[0];
		const postView = document.getElementById("post-view");
		const newView = document.createElement("a");
		newView.setAttribute("href", "index.php?page=post&post_id="+post.post_id);
		newView.setAttribute("class", "image");
		const newViewImg = document.createElement("img");
		newViewImg.setAttribute("src", "app/assets/img/posts/" + post.path);
		newView.appendChild(newViewImg);
		if (postView.childElementCount === 4)
			postView.removeChild(postView.lastElementChild);
		postView.prepend(newView);
	}

	function CreatePost()	{
		const sticker = document.getElementById("sticker");
		const context = canvas.getContext('2d');
		context.drawImage(video, 0, 0, width, height);
		const data = canvas.toDataURL('image/png');
		SendPicture(data, sticker.firstChild.src);
		sticker.removeChild(sticker.firstChild);
	}

	window.addEventListener('load', StartStream, false);
})();

function ClearNotif() {
	const sections = document.getElementsByClassName("card-content");
	for (let section of sections) {
		let notif = section.getElementsByClassName("notification").item(0);
		if (notif !== null)
			section.removeChild(notif);
	}
}

function DisplayNotif(targetID, message) {
	ClearNotif();
	const target = document.getElementById(targetID);
	const box = document.createElement("div");
	box.setAttribute("class", "notification is-warning");
	box.innerHTML = "- "+message+"<br>";
	target.prepend(box);
}

const input = document.getElementById( 'file-input' );
const infoArea = document.getElementById( 'file-name' );
input.addEventListener( 'change', function (e) { 
  const input = event.srcElement;
  const fileName = input.files[0].name;
  infoArea.innerHTML = fileName;
});