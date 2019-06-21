document.addEventListener("click", function(e) {
    const token = document.getElementById("token").value;
    if (event.target.matches(".delete-btn")) {
        e.preventDefault();
        DeletePostGallery(event.target);
    }
    if (event.target.matches("#delete-btn")) {
        e.preventDefault();
        DeletePost(event.target);
    }

    function DeletePostGallery(target) {
        const confirm = window.confirm("You are about to delete your post. Are you sure ?");
        if (confirm) {
            const postCard = target.closest(".card");
            const parent = postCard.parentNode;
            const postID = postCard.id;
            const post = "action=deletePost"
                        +"&postID="+postID
                        +"&token="+token;
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        parent.removeChild(postCard);
						document.location.href="/";
                    }
                }
            }
            xhr.open("POST", "app/controllers/postController.php");
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(post);
        }
    }

    function DeletePost(target) {
        const confirm = window.confirm("You are about to delete your post. Are you sure ?");
        if (confirm) {
            const postCard = target.closest(".card");
            const postID = postCard.id;
            const post = "action=deletePost"
                        +"&postID="+postID
                        +"&token="+token;
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.location.href="index.php";
                    }
                }
            }
            xhr.open("POST", "app/controllers/postController.php");
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(post);
        }
    }
})