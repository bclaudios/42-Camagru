document.addEventListener("click", function(e) {
    if (event.target.matches("#rstPasswd-btn")) {
        e.preventDefault();
        SendResetPassword();
    }

    if (event.target.matches("#update-passwd")) {
        e.preventDefault();
        ResetPassword();
    }
})

function SendResetPassword() {
    const token = document.getElementById("token").value;
    const login = document.getElementById("input-login").value;
    const post = "action=sendResetPasswd"
                +"&login="+login
                +"&token="+token
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()	{
        if (xhr.readyState === 4)	{
            if (xhr.status === 200)
                DisplaySuccessNotif("reset-section", xhr.responseText);
            else
                DisplayErrorNotif("reset-section", xhr.responseText);
        }
    }
    xhr.open("POST", "app/controllers/userController.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(post);
}

function ResetPassword() {
    const token = document.getElementById("token").value;
    const passwd = document.getElementById("input-newPasswd").value;
    const passwdConf = document.getElementById("input-newPasswdConf").value;
    const post = "action=resetPasswd"
    +"&passwd="+passwd
    +"&passwdConf="+passwdConf
    +"&token="+token;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()	{
        if (xhr.readyState === 4)	{
            if (xhr.status === 200)
                DisplaySuccessNotif("passwd-edit", xhr.responseText);
            else
                DisplayErrorNotif("passwd-edit", xhr.responseText);
        }
    }
    xhr.open("POST", "app/controllers/userController.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(post);
}

// NOTIF FUNCTIONS

function ClearNotif() {
	const sections = document.getElementsByClassName("edit-section");
	for (let section of sections) {
		let notif = section.getElementsByClassName("notification").item(0);
		if (notif !== null)
			section.removeChild(notif);
	}
}

function DisplayErrorNotif(targetID, errorLogs) {
	ClearNotif();
	errorLogs = JSON.parse(errorLogs);
	const target = document.getElementById(targetID);
	const box = document.createElement("div");
	box.setAttribute("class", "notification is-danger");
	for (let error in errorLogs) {
		box.innerHTML = box.innerHTML+"- "+errorLogs[error]+"<br>";
	}
	target.prepend(box);
}

function DisplaySuccessNotif(targetID, message) {
	ClearNotif();
	const target = document.getElementById(targetID);
	const box = document.createElement("div");
	box.setAttribute("class", "notification is-success");
	box.innerHTML = "- "+message+"<br>";
	target.prepend(box);
}