<?php
require_once("models/userModel.php");

##### VIEWS #####

function view_Home()	{
	$title = "Home";
	require_once("views/main.php");
}

function view_SignUp()	{
	$title = "Sign Up";
	require_once("views/signup.php");
}

function view_SignIn()	{
	$title = "Sign In";
	require_once("views/signin.php");
}

function view_Profil()	{
	$title = "Profil";
	$user = db_GetUser($_SESSION['user']);
	require_once("views/profil.php");
}

function view_EditUserInfos()	{
	$title = "Edit Infos";
	$user = db_GetUser($_SESSION['user']);
	require_once("views/editprofil.php");
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
	$passwd = hash("sha256", $_POST['passwd']);
	$user = db_GetUser($_POST['login']);
	if ($user === FALSE)
		die("This user does not exist.");
	if ($user['passwd'] !== $passwd)
		die ("Wrong password.");
	$_SESSION['user'] = $user['login'];
	$alertTitle = "Welcome " . $user['login'];
	$alertMessage = "You have successfully logged in.";
	require("elements/alert.php");
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
	require("elements/alert.php");
}