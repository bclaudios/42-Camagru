document.addEventListener("click", function(e)	{
	if (event.target.matches("#update-infos")) {
		e.preventDefault();
		UpdateInfos();
	}
	if (event.target.matches("#update-passwd"))	{
		e.preventDefault();
		UpdatePassword();
	}
	if (event.target.matches("#delete-account")) {
		e.preventDefault();
		DeleteAccount();
	}
	
	function UpdateInfos() {
		const login = document.getElementById("input-login");
		const email = document.getElementById("input-email");
		const notif = document.getElementById("input-notif");
		const loginTitle = document.getElementById("title-login");
		const post = "action=updateInfos"
					+"&login="+login.value
					+"&email="+email.value
					+"&notif="+notif.value
					+"&token="+token;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					DisplaySuccessNotif("general-edit", "Informations successfully changed.");
					loginTitle.innerHTML = login.value;
				} else {
					DisplayErrorNotif("general-edit", xhr.responseText);
				}
			}
		}
		xhr.open("POST", "app/controllers/userController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
	
	function UpdatePassword() {
		const passwd = document.getElementById("input-passwd").value;
		const newPasswd = document.getElementById("input-newPasswd").value;
		const newPasswdConf = document.getElementById("input-newPasswdConf").value;
		const post = "action=updatePasswd"
					+"&passwd="+passwd
					+"&newPasswd="+newPasswd
					+"&newPasswdConf="+newPasswdConf
					+"&token="+token;
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200)
					DisplaySuccessNotif("passwd-edit", "Password successfully updated.");
				else
					DisplayErrorNotif("passwd-edit", xhr.responseText);
			}
		}
		xhr.open("POST", "app/controllers/userController.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(post);
	}
	
	function DeleteAccount() {
		const confirmation = confirm("You are about to delete your account. Are you sure you want to do this ? (This action can'tbe revoqued)");
		if (confirmation) {
			const post = "action=deleteAccount"
						+"&token="+token;
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4) {
					if (xhr.status === 200)
						document.location.href="/";
					else
						DisplayErrorNotif("delete-edit", "Sorry, something went wrong.");
				}
			}
			xhr.open("POST", "app/controllers/userController.php");
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(post);
		}
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
});
