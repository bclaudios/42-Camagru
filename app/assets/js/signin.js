document.addEventListener("click", function(e) {
	if (event.target.matches("#signin_btn"))	{
		e.preventDefault();
		const login = document.getElementById("input_login").value;
		const passwd = document.getElementById("input_passwd").value;
		const post = "action=signIn"
		+"&login="+login
		+"&passwd="+passwd;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
			if (xhr.readyState === 4)	{
				if (xhr.status === 200)	{
					alert(xhr.responseText);
					window.location = "index.php";
				} else {
					alert(xhr.responseText);
				}
			}
		}
		xhr.open('POST', 'app/controllers/userController.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
});