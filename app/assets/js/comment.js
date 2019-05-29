document.addEventListener("click", function(e) {
	if (event.target.matches(".comment_btn")) {
		e.preventDefault();
		const post_id = event.target.closest(".card").id;
		const card = document.getElementById(post_id);
		const comment = card.getElementsByClassName("input").item(0).value;
		if (comment != "") {
			const form = card.getElementsByTagName("form").item(0);
			const post = "action=addComment"
							+"&comment="+comment
							+"&post_id="+post_id;
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

	if (event.target.matches(".show_comments")) {
		const card = event.target.closest(".card");
		const post_id = card.id;
		const show_btn = event.target;
		const commentList = document.getElementById(post_id).getElementsByClassName("comment_list").item(0);
		const post = "action=getComments"
					+"&post_id="+post_id;
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
		if (xhr.readyState === 4)	{
			if (xhr.status === 200) {
				while (commentList.firstChild)	{
					commentList.removeChild(commentList.firstChild);
				}
				DisplayAllComments(xhr.responseText);
				show_btn.innerHTML = "Hide";
				show_btn.setAttribute("class", "button hide_comments");
			}
			else
				alert(xhr.responseText);
			}
		}
		xhr.open("POST", "app/controllers/postController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}

	if (event.target.matches(".hide_comments")) {
		const post_id = event.target.closest(".card").id;
		const hide_btn = event.target;
		HideAllComments(post_id);
		hide_btn.innerHTML = "Show more";
		hide_btn.setAttribute("class", "button show_comments");
	}

	function DisplayComment(comment) {
		const commentList = document.getElementById(comment.post_id).getElementsByClassName("comment_list").item(0);
		const newComment = document.createElement("div");
		newComment.setAttribute("class", "comment content");
		newComment.innerHTML = "<p><a href='index.php?page=profil&login="+comment.login+"'><strong>"+comment.login+" </strong></a><small><i>"+comment.date+" "+comment.time+"</i></small><br>"+comment.comment+"</p>";
		commentList.appendChild(newComment);
	}

	function DisplayAllComments(JSONComments) {
		const comments = JSON.parse(JSONComments);
		for (let comment in comments) {
			DisplayComment(comments[comment]);
		}
	}

	function HideAllComments(post_id) {
		const card = document.getElementById(post_id);
		const commentList = card.getElementsByClassName("comment_list").item(0);
		const allComments = commentList.getElementsByClassName("comment");
		const firstComment = allComments.item(0);
		while (commentList.firstChild)	{
			commentList.removeChild(commentList.firstChild);
		}
		commentList.appendChild(firstComment);
	}
})
