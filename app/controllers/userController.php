<?php
require_once __DIR__.'/../models/userModel.php';

##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "signin")
		LogUser();
	if ($action === "signup")
		RegisterUser();
}
##### VIEWS #####

function view_Home()	{
	$title = "Home";
	require_once("app/views/pages/main.php");
}

function view_SignUp()	{
	$title = "Sign Up";
	require_once("app/views/pages/signup.php");
}

function view_SignIn()	{
	$title = "Sign In";
	require_once("app/views/pages/signin.php");
}

function view_Profil()	{
	$title = "Profil";
	$user = db_GetUser($_SESSION['user']);
	require_once("app/views/pages/profil.php");
}

function view_EditUserInfos()	{
	$title = "Edit Infos";
	$user = db_GetUser($_SESSION['user']);
	require_once("app/views/pages/editprofil.php");
}

##### ACTIONS #####

function CheckSignUpInfos()	{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		die ("Wrong email format.");
	if ($_POST['email'] !== $_POST['emailConf'])
		die ("Email adresses not matching.");
	if ($_POST['passwd'] !== $_POST['passwdConf'])
		die ("Passwords not matching.");
	$error = db_UserExist();
	if ($error)
		die ($error);
}

// E-mail verification missing
function RegisterUser()	{
	CheckSignUpInfos();
	$_POST['passwd'] = hash('sha256', $_POST['passwd']);
	db_AddUser();
	header("Location: index.php");
	exit();
}

function LogUser()	{
	session_start();
	$passwd = hash("sha256", $_POST['passwd']);
	$user = db_GetUser($_POST['login']);
	if ($user === FALSE || $user['passwd'] !== $passwd)	{
		http_response_code(400);
		echo "Login or password incorrect.";
	}
	$_SESSION['user'] = $user['login'];
}

function LogOutUser()	{
	unset($_SESSION['user']);
	view_Home();
}

function UpdateUserProfil()	{
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

function UpdateUserPasswd()	{
	$user = db_GetUser($_SESSION['user']);
	$passwdConf = hash("sha256", $_POST['currentPasswd']);
	$newPasswd = hash("sha256", $_POST['newPasswd']);
	if ($passwdConf !== $user['passwd'])
		die ("Wrong password");
	db_UpdateUserPasswd($newPasswd);
}