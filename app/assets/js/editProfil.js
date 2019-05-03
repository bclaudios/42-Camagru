const editProfil_btn = document.getElementById("editProfil_btn");
const editPasswd_btn = document.getElementById("editPasswd_btn");

// Profil Update
editProfil_btn.addEventListener("click", function()	{
	const newLogin = document.getElementById("edit_newLogin").value;
	const newEmail = document.getElementById("edit_newEmail").value;
	const newEmailConf = document.getElementById("edit_newEmailConf").value;
	const post = "action=updateProfil"
				+"&newLogin="+newLogin
				+"&newEmail="+newEmail
				+"&newEmailConf="+newEmailConf;
	const xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4)	{
			alert(xhr.responseText);
		}
	}
	xhr.open("POST", "app/controllers/userController.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(post);
});

// Password Update
editPasswd_btn.addEventListener("click", function()	{
	const currentPasswd = document.getElementById("edit_currentPasswd").value;
	const newPasswd = document.getElementById("edit_newPasswd").value;
	const newPasswdConf = document.getElementById("edit_newPasswdConf").value;
	const post = "aciton=updatePasswd"
				+"&currentPasswd="+currentPasswd
				+"&newPasswd="+newPasswd
				+"&newPasswdConf"+newPasswdConf;
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
})