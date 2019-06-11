document.addEventListener("click", function(e) {
	const token = document.getElementById("token").value;
	if (event.target.matches(".comment_btn")) {
		e.preventDefault();
		AddComment(event.target);
	}
	if (event.target.matches(".comment-delete")) {
		e.preventDefault();
		DeleteComment(event.target);
	}

	function AddComment(target) {
		const post_id = target.closest(".card").id;
		const card = document.getElementById(post_id);
		const comment = card.getElementsByClassName("input").item(0).value;
		if (comment != "") {
			const form = card.getElementsByTagName("form").item(0);
			const post = "action=addComment"
			+"&comment="+comment
			+"&post_id="+post_id
			+"&token="+token;
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()	{
				if (xhr.readyState === 4)	{
					if (xhr.status === 200) {
						form.reset();
						DisplayComment(JSON.parse(xhr.responseText));
					}
					else
						alert(xhr.responseText);
				}
			}
			xhr.open("POST", "app/controllers/postController.php");
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(post);
		}
	}
	
	function DeleteComment(target) {
		const comment = event.target.closest(".comment");
			const post = "action=delComment"
						+"&commentID="+comment.id
						+"&token="+token;
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						alert(xhr.responseText);
						DeleteCommentBox(comment);
					} else {
						alert(xhr.responseText);
					}
				}
			}
			xhr.open("POST", "app/controllers/postController.php");
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(post);
	}
	
	function DeleteCommentBox(comment) {
		const commentList = comment.closest(".comment_list");
		commentList.removeChild(comment);
	}
	
	function DisplayComment(comment) {
		const commentList = document.getElementById(comment.post_id).getElementsByClassName("comment_list").item(0);
		const newComment = document.createElement("div");
		newComment.setAttribute("class", "comment content");
		newComment.innerHTML = '<div class="level"><div class="level-left"><a href="index.php?page=profil&login='+comment.login+'" class="comment-login"><strong>'+comment.login+'</strong></a><small><i class="comment-time">'+comment.date+' '+comment.time+'</i></small><br></div><div class="level-right"><a class="comment-delete">X</a></div></div>'+comment.comment;
		commentList.appendChild(newComment);
	}
})
