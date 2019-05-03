const signUp_btn = document.getElementById("signup_btn");

signUp_btn.addEventListener("click", function(e) {
	e.preventDefault();
	const login = document.getElementById("signup_login").value;
	const email = document.getElementById("signup_email").value;
	const emailConf = document.getElementById("signup_emailConf").value;
	const passwd = document.getElementById("signup_passwd").value;
	const passwdConf = document.getElementById("signup_passwdConf").value;
	const post = "action=signUp"
				+"&login="+login
				+"&email="+email
				+"&emailConf="+emailConf
				+"&passwd="+passwd
				+"&passwdConf="+passwdConf;
	const xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()	{
		if (xhr.readyState === 4)	{
			if (xhr.status === 200)	{
				alert(xhr.responseText);
				window.location = "index.php";
			}
			if (xhr.status === 400)	{
				alert(xhr.responseText);
			}
		}
	}
	xhr.open("POST", "app/controllers/userController.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(post);
});