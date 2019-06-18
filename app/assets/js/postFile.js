document.addEventListener("click", function(e)	{
	if (event.target.matches("#post-btn"))	{
		e.preventDefault();
		CreatePost();
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
	postView.removeChild(postView.lastElementChild);
	postView.prepend(newView);
}

const input = document.getElementById( 'file-input' );
const infoArea = document.getElementById( 'file-name' );
input.addEventListener( 'change', function (e) { 
  const input = event.srcElement;
  const fileName = input.files[0].name;
  infoArea.innerHTML = fileName;
});