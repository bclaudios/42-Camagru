document.addEventListener("click", function(e) {
	if (event.target.matches(".like-btn")) {
		const card = event.target.closest(".card");
		const post_id = card.id;
		const icon = event.target;
		const post = "action=addLike"
					+"&post_id="+post_id;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				alert(xhr.responseText);
				icon.setAttribute("src", "app/assets/img/icon/heart-filled.png");
				icon.setAttribute("class", "unlike-btn");
			}
		}
		xhr.open("POST", "app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
	
	if (event.target.matches(".unlike-btn")) {
		const card = event.target.closest(".card");
		const post_id = card.id;
		const icon = event.target;
		const post = "action=addLike"
		+"post_id="+post_id;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				icon.setAttribute("src", "app/assets/img/icon/heart-empty.png");
				icon.setAttribute("class", "like-btn");
			}
		}
		xhr.open("POST", "app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
})