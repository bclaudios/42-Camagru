<?php
require_once __DIR__.'/../models/userModel.php';

##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "signIn")
		UserSignIn();
	if ($action === "signUp")
		UserSignUp();
	if ($action === "updateProfil")
		UserUpdateProfil();
}
##### VIEWS #####
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
	$user = db_GetUser($_SESSION['user']);
	require_once("app/views/pages/profil.php");
}

function view_EditProfil()	{
	$title = "Edit Infos";
	$user = db_GetUser($_SESSION['user']);
	require_once("app/views/pages/editProfil.php");
}

##### ACTIONS #####
function CheckSignUpInfos()	{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		$errorLogs[] = "Wrong email format.";
	if ($_POST['email'] !== $_POST['emailConf'])
		$errorLogs[] = "Email adresses not matching.";
	if ($_POST['passwd'] !== $_POST['passwdConf'])
		$errorLogs[] = "Passwords not matching.";
	$userExist = db_UserExist($_POST['login'], $_POST['email']);
	if ($userExist)
		$errorLogs[] = $userExist;
	if (!isset($errorLogs))
		return NULL;
	return implode("\n", $errorLogs);
}

// E-mail verification missing
function UserSignUp()	{
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
		db_CreateUser($user);
		echo "Registration complete.\nPlease confirm your address by clicking on the link sent at the one you specified.";
	}
}

function UserSignIn()	{
	session_start();
	$passwd = hash("sha256", $_POST['passwd']);
	$user = db_GetUser($_POST['login']);
	if ($user === FALSE || $user['passwd'] !== $passwd)	{
		http_response_code(400);
		echo "Login or password incorrect.";
	} else {
		$_SESSION['user'] = $user['login'];
		echo "You are now logged in.";
	}
}

function UserLogOut()	{
	unset($_SESSION['user']);
	view_Home();
}

function UserUpdateProfil()	{
	$user = db_GetUser($_SESSION['user']);
	if ($user['login'] !== $_POST['newLogin'])	{
		if (db_GetUser($_POST['newLogin']))
			die ("Login is already used.");
		}
		if ($user['email'] !== $_POST['newEmail'])	{
			if (db_GetUser($_POST['newEmail']))
			die ("E-mail address already used.");
		}
	db_UpdateUser();
	$alertTitle = "Informations changed";
	$_SESSION['user'] = $_POST['newLogin'];
	$alertMessage = "Your informations has been successfully updated.";
	require("app/views/pages/alert.php");
}

function UserUpdatePasswd()	{
	$user = db_GetUser($_SESSION['user']);
	$passwdConf = hash("sha256", $_POST['currentPasswd']);
	$newPasswd = hash("sha256", $_POST['newPasswd']);
	if ($passwdConf !== $user['passwd'])
		die ("Wrong password");
	db_UserUpdatePasswd($newPasswd);
}