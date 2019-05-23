document.addEventListener("click", function(e) {
	if (event.target.matches(".comment_btn")) {
		e.preventDefault();
		const id = event.target.getAttribute("btn_id");
		const input = document.querySelector("input[input_id='"+id+"']").value;
		const post = "action=addComment"
						+"&comment="+input
						+"&post_id="+id;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
			if (xhr.readyState === 4)	{
				if (xhr.status === 200)
					DisplayComment(input, id);
				else
					alert(xhr.responseText);
			}
		}
		xhr.open("POST", "app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}

	function DisplayComment(comment, post_id) {
		const commentList = document.querySelector("div[comment_id='"+post_id+"']");
		const newComment = document.createElement("div");
		newComment.setAttribute("class", "content");
		newComment.innerText = comment;
		commentList.appendChild(newComment);
	}
})
