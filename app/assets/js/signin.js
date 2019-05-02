const signIn_btn = document.getElementById("signin_btn");

signIn_btn.addEventListener("click", function(e) {
	e.preventDefault();
	const login = document.getElementById("input_login");
	const passwd = document.getElementById("input_passwd");
	const action = "action=signin&login="+login.value+"&passwd="+passwd.value;
	const httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()	{
		if (httpRequest.readyState === 4)	{
			if (httpRequest.status === 200)	{
				alert("You are now logged in.");
				window.location = "index.php";
			} else {
				alert(httpRequest.responseText);
			}
		}
	}
	httpRequest.open('POST', './app/controllers/userController.php', true);
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpRequest.send(action);
});