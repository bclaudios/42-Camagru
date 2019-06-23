document.addEventListener("click", function(e)	{
	if (event.target.matches("#post-btn"))	{
		stickerSelected = document.getElementById("sticker");
		if (stickerSelected.firstChild !== null)
			CreatePost();
		else
			DisplayNotif("montage-ui", "Please, select a sticker before taking a picture.");
	}
})

function CreatePost() {
	const token = document.getElementById("token").value;
	const image = document.getElementById("uploaded_img").src;
		const sticker = document.getElementById("sticker").firstChild.src;
		const post = "action=createPost"
					+"&token="+token
					+"&img="+image
					+"&sticker="+sticker+
					"&source=file";
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
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