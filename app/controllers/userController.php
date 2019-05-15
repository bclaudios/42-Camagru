<?php
require_once __DIR__.'/../models/UserModel.php';
session_start();

########## CONTROLLER ##########
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "signIn")
		SignIn();
	if ($action === "signUp")
		SignUp();
	if ($action === "editLogin")
		UpdateLogin();
	if ($action === "editEmail")
		UpdateEmail();
	if ($action === "editPasswd")
		UpdatePasswd();
}

########## VIEWS ##########
function view_Home()	{
	$title = "Home";
	require_once("app/views/pages/main.php");
}

function view_SignUp()	{
	$title = "Sign Up";
	require_once("app/views/pages/signUp.php");
}

function view_SignIn()	{
	$title = "Sign In";
	require_once("app/views/pages/signIn.php");
}

function view_Profil()	{
	$title = "Profil";
	$user = GetCurrentUser();
	require_once("app/views/pages/profil.php");
}

function view_EditProfil()	{
	$title = "Edit Infos";
	$user = GetCurrentUser();
	require_once("app/views/pages/editProfil.php");
}

########## ACTIONS ##########
function CheckSignUpInfos()	{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		$errorLogs[] = "Wrong email format.";
	if ($_POST['email'] !== $_POST['emailConf'])
		$errorLogs[] = "Email adresses not matching.";
	if (!CheckPasswdSecurity($_POST['passwd']))
		$errorLogs[] = "Password security error. Must contain at least 8 chars, 1 lowercase, 1 uppercase and 1 digit.";
	if ($_POST['passwd'] !== $_POST['passwdConf'])
		$errorLogs[] = "Passwords not matching.";
	$userExist = UserModel::db_UserExist($_POST['login'], $_POST['email']);
	if ($userExist)
		$errorLogs[] = $userExist;
	if (!isset($errorLogs))
		return NULL;
	return implode("\n", $errorLogs);
}

function SignUp()	{
	$errorLogs = CheckSignUpInfos();
	if ($errorLogs)	{
		http_response_code(400);
		echo $errorLogs;
	} else {
		$user = array(
			"login" => $_POST['login'],
			"email" => $_POST['email'],
			"passwd" => hash('sha256', $_POST['passwd'])
		);
		//ADD EMAIL VERIFICATION HERE
		UserModel::db_CreateUser($user);
		echo "Registration complete.\nPlease confirm your address by clicking on the link sent at the one you specified.";
	}
}
// E-mail verification missing

function SignIn()	{
	$passwd = hash("sha256", $_POST['passwd']);
	$user = UserModel::db_GetUser($_POST['login']);
	if ($user === FALSE || $user['passwd'] !== $passwd)	{
		http_response_code(400);
		echo "Login or password incorrect.";
	} else {
		$_SESSION['user'] = $user['login'];
		echo "You are now logged in.";
	}
}

function LogOut()	{
	unset($_SESSION['user']);
	view_Home();
}


#####	Profil updates
function UpdateLogin()	{
	$user = GetCurrentUser();
	$newLogin = $_POST['newLogin'];
	if ($user["login"] !== $newLogin)	{
		if (UserModel::db_GetUser($newLogin))	{
			http_response_code(400);
			echo "This username is already used.";
		} else	{
			UserModel::db_UpdateLogin($newLogin);
			$_SESSION['user'] = $newLogin;
			echo "Your username has been set to : " . $newLogin . ".";
		}
	} else {
		http_response_code(400);
		echo "Same username.";
	}
}

function UpdateEmail()	{
	$user = GetCurrentUser();
	$newEmail = $_POST['newEmail'];
	$newEmailConf = $_POST['newEmailConf'];
	if ($user["email"] !== $newEmail)	{
		if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))	{
			http_response_code(400);
			echo "Wrong email format.";
		}
		elseif ($newEmail !== $newEmailConf)	{
			http_response_code(400);
			echo "Email adresses not matching with each other.";
		}
		elseif (UserModel::db_CheckEmail($newEmail))	{
			http_response_code(400);
			echo "This email address is already used.";
		} else {
			UserModel::db_UpdateEmail($newEmail);
			//ADD EMAIL VERIFICATION HERE
			echo "Your email address has been set to : " . $newEmail . ".\nA new confirmation is required. Please check you inbox.";
		}
	} else {
		http_response_code(400);
		echo "Same email address.";
	}
}

function UserUpdateProfil()	{
	$user = GetCurrentUser();
	if ($user['login'] !== $_POST['newLogin'])	{
		if (UserModel::db_GetUser($_POST['newLogin']))
			die ("Login is already used.");
		}
		if ($user['email'] !== $_POST['newEmail'])	{
			if (UserModel::db_GetUser($_POST['newEmail']))
			die ("E-mail address already used.");
		}
	UserModel::db_UpdateUser();
	$alertTitle = "Informations changed";
	$alertMessage = "Your informations has been successfully updated.";
	require("app/views/pages/alert.php");
}

function UpdatePasswd()	{
	$user = GetCurrentUser();
	$currentPasswd = hash("sha256", $_POST['currentPasswd']);
	$newPasswd = hash("sha256", $_POST['newPasswd']);
	$newPasswdConf = hash("sha256", $_POST['newPasswdConf']);
	if ($currentPasswd !== $user['passwd'])	{
		http_response_code(400);
		echo "Wrong current password.";
	} elseif ($newPasswd !== $newPasswdConf)	{
		http_response_code(400);
		echo "Passwords not matching.";
	} elseif (!CheckPasswdSecurity($_POST['newPasswd'])) {
		http_response_code(400);
		echo "New password security too low.";
	} else {
		UserModel::db_UpdatePasswd($newPasswd);
		echo "You're password has been changed.";
	}
}

#####	Tools
function CheckPasswdSecurity($passwd)	{
	if (!preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$^", $passwd))
		return FALSE;
	return TRUE;
}

function GetCurrentUser()	{
	return UserModel::db_GetUser($_SESSION['user']);
}