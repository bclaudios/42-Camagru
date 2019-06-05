<?php
session_start();
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/postController.php';

########## CONTROLLER ##########

if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "signIn")
		SignIn();
	if ($action === "signUp")
		SignUp();
	if ($action === "updateInfos")
		UpdateInfos();
	if ($action === "updatePasswd")
		UpdatePasswd();
	if ($action === "deleteAccount")
		DeleteAccount();
}

########## VIEWS ##########

function view_SignUp()	{
	$title = "Sign Up";
	require_once(__DIR__."/../views/pages/signUp.php");
}

function view_SignIn()	{
	$title = "Sign In";
	require_once(__DIR__."/../views/pages/signIn.php");
}

function view_Profil()	{
	$title = "Profil";
	$login = $_GET['login'];
	$user = UserModel::db_GetUser($login);
	$posts = PostModel::db_GetPostsFromUser($user['user_id']);
	require_once(__DIR__."/../views/pages/profil.php");
}

function view_EditProfil()	{
	$title = "Edit Infos";
	$user = GetCurrentUser();
	require_once(__DIR__."/../views/pages/profilEdit.php");
}

########## SIGN UP ##########

function CheckSignUpInfos()	{
	if (CheckNewLogin($_POST['login']))
		$errorLogs[] = CheckNewLogin($_POST['login']);
	if (CheckNewEmail($_POST['email']))
		$errorLogs[] = CheckNewEmail($_POST['email']);
	if (!CheckPasswdSecurity($_POST['passwd']))
		$errorLogs[] = "Password security is too low. Must contain at least 8 chars, 1 lowercase, 1 uppercase and 1 digit.";
	if ($_POST['passwd'] !== $_POST['passwdConf'])
		$errorLogs[] = "Passwords not matching.";
	if (!isset($errorLogs))
		return NULL;
	return $errorLogs;
}

function SignUp()	{
	$errorLogs = CheckSignUpInfos();
	if (!empty($errorLogs))	{
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
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

###### SIGN IN | LOGOUT ######

function SignIn()	{
	$passwd = hash("sha256", $_POST['passwd']);
	$user = UserModel::db_GetUser($_POST['login']);
	if ($user === FALSE || $user['passwd'] !== $passwd)	{
		http_response_code(400);
		$errorLogs[] = "Login or password incorrect.";
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	} else {
		$_SESSION['user'] = $user['login'];
		echo "You are now logged in.";
	}
}

function LogOut()	{
	unset($_SESSION['user']);
	header("Location: index.php");
}


###### INFOS UPDATE ######

function UpdateInfos() {
	$user = GetCurrentUser();
	$newLogin = $_POST['login'];
	$newEmail = $_POST['email'];
	$notif = $_POST['notif'];
	if (!empty($newLogin) && $newLogin !== $user['login'])
		$errorLogs[] = CheckNewLogin($newLogin);
	if (!empty($newEmail) && $newEmail !== $user['email'])
		$errorLogs[] = CheckNewEmail($newEmail);
	if (!isset($errorLogs[0])) {
		if (!empty($newLogin) && $newLogin !== $user['login']) {
			UserModel::db_UpdateLogin($newLogin);
			$_SESSION['user'] = $newLogin;
		}
		if (!empty($newEmail) && $newEmail !== $user['email'])
			UserModel::db_UpdateEmail($newEmail);
		UserModel::db_UpdateNotif($notif);
	} else {
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	}
}

function CheckNewLogin($newLogin)	{
	if (UserModel::db_GetUser($newLogin))
		return "This username is already used.";
	return NULL;
}

function CheckNewEmail($newEmail)	{
	if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
		$errors[] = "Wrong email format.";
	elseif (UserModel::db_CheckEmailExist($newEmail))
		$errors[] = "This email address is already used.";
	if (!isset($errors))
		return NULL;
	return $errors;
}

###### PASSWORD UPDATE ######

function UpdatePasswd()	{
	$user = GetCurrentUser();
	$passwd = hash("sha256", $_POST['passwd']);
	$newPasswd = hash("sha256", $_POST['newPasswd']);
	$newPasswdConf = hash("sha256", $_POST['newPasswdConf']);
	if ($passwd !== $user['passwd'])
		$errorLogs[] = "Wrong current password.";
	elseif ($newPasswd !== $newPasswdConf)
		$errorLogs[] = "Passwords not matching.";
	elseif (!CheckPasswdSecurity($_POST['newPasswd']))
		$errorLogs[] = "New password security too low.";
	if (!isset($errorLogs[0]))
		UserModel::db_UpdatePasswd($newPasswd);
	else {
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	}
}

##### ACCOUNT SUPPRESSION ######

function DeleteAccount() {
	$user = GetCurrentUser();
	UserModel::db_DeleteUser($user['login']);
	unset($_SESSION['user']);
}

###### TOOLS ######

function CheckPasswdSecurity($passwd)	{
	if (!preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$^", $passwd))
		return FALSE;
	return TRUE;
}

function GetCurrentUser()	{
	if (isset($_SESSION['user']))
		return UserModel::db_GetUser($_SESSION['user']);
	return NULL;
}