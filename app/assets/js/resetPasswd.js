document.addEventListener("click", function(e) {
    if (event.target.matches("#rstPasswd-btn")) {
        e.preventDefault();
        SendResetPassword();
    }

    if (event.target.matches("#changePasswd-btn")) {
        e.preventDefault();
        ResetPassword();
    }
})

function SendResetPassword() {
    const login = document.getElementById("input-login").value;
    const post = "action=sendResetPasswd"
                +"&login="+login;
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
    const passwd = document.getElementById("input-passwd").value;
        const passwdConf = document.getElementById("input-passwdConf").value;
        const post = "action=sendResetPasswd"
                    +"&passwd=".passwd
                    +"&passwdConf=".passwdConf;
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