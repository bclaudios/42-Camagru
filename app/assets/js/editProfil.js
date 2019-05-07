document.addEventListener("click", function(e)	{
	// Login Update
	if (event.target.matches("#editLogin_btn"))	{
		e.preventDefault();
		const newLogin = document.getElementById("newLogin").value;
		const post = "action=editLogin"
					+"&newLogin="+newLogin;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4)
				alert(xhr.responseText);
		}
		xhr.open("POST", "app/controllers/userController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
	
	//	Email Update
	if (event.target.matches("#editEmail_btn"))	{
		e.preventDefault();
		const newEmail = document.getElementById("newEmail").value;
		const newEmailConf = document.getElementById("newEmailConf").value;
		const post = "action=editEmail"
					+"&newEmail="+newEmail
					+"&newEmailConf="+newEmailConf;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
			if (xhr.readyState === 4)
				alert(xhr.responseText);
		}
		xhr.open("POST", "/app/controllers/userController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
	
	// Password Update
	if (event.target.matches("#editPasswd_btn"))	{
		e.preventDefault();
		const currentPasswd = document.getElementById("edit_currentPasswd").value;
		const newPasswd = document.getElementById("edit_newPasswd").value;
		const newPasswdConf = document.getElementById("edit_newPasswdConf").value;
		const post = "action=editPasswd"
					+"&currentPasswd="+currentPasswd
					+"&newPasswd="+newPasswd
					+"&newPasswdConf="+newPasswdConf;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()	{
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4)	{
					alert(xhr.responseText);
				}
			}
		}
		xhr.open("POST", "app/controllers/userController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
});