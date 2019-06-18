document.addEventListener("click", function(e) {
	if (event.target.matches(".like-btn")) {
		AddLike(event.target);
	}
	
	if (event.target.matches(".unlike-btn")) {
		RemoveLike(event.target);
	}
})

document.addEventListener("dblclick", function(e) {
	if (event.target.matches(".card-image")) {
		if (event.target.closest(".card").getElementsByClassName("like-btn").item(0))
			AddLike(event.target);
		else
			RemoveLike(event.target);
	}
})

function AddLike(target) {
	const token = document.getElementById("token").value;	
	const card = target.closest(".card");
	const post_id = card.id;
	const icon = card.getElementsByClassName("like-btn").item(0);
	const likesDisplay = card.getElementsByClassName("like-count").item(0);
	const likesCount = parseInt(likesDisplay.innerHTML) > 0 ? likesDisplay.innerHTML : 0;
	const post = "action=addLike"
				+"&post_id="+post_id
				+"&token="+token;
	const xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			likesDisplay.innerHTML = parseInt(likesCount) + 1;
			icon.setAttribute("src", "app/assets/img/icon/heart-filled.png");
			icon.setAttribute("class", "unlike-btn");
		}
	}
	xhr.open("POST", "app/controllers/postController.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(post);
}

function RemoveLike(target) {
	const token = document.getElementById("token").value;	
	const card = target.closest(".card");
	const post_id = card.id;
	const icon = card.getElementsByClassName("unlike-btn").item(0);
	const likesDisplay = card.getElementsByClassName("like-count").item(0);
	const likesCount = parseInt(likesDisplay.innerHTML) > 0 ? likesDisplay.innerHTML : 0;
	const post = "action=removeLike"
				+"&post_id="+post_id
				+"&token="+token;
	const xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			likesDisplay.innerHTML = parseInt(likesCount) - 1;
			icon.setAttribute("src", "app/assets/img/icon/heart-empty.png");
			icon.setAttribute("class", "like-btn");
		}
	}
	xhr.open("POST", "app/controllers/postController.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(post);
}