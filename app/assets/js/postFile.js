document.addEventListener("click", function(e)	{
	if (event.target.matches("#post_btn"))	{
		const image = document.getElementById("uploaded_img").src;
		const sticker = document.getElementById("sticker").firstChild.src;
		const post = "action=createPost"
					+"&img="+image
					+"&sticker="+sticker+
					"&source=file";
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
			if (xhr.readyState === 4)	{
				alert(xhr.responseText);
			}
		}
		xhr.open("POST", "/app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
})