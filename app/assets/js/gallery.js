window.onscroll = function(e) {
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
        const offset = document.getElementsByClassName("post-card").length;
        const post = "action=updateGallery"
                    +"&offset="+offset
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				DisplayAllCard(JSON.parse(xhr.responseText));
			}
		}
		xhr.open("POST", "app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(post);
    }
}

function DisplayAllCard(posts) {
    const container = document.getElementById("card-container");
    for (let post in posts) {
        const card = document.createElement("div");
        card.innerHTML = posts[post];
        container.appendChild(card);
    }
}