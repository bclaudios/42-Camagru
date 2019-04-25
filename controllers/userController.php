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

##### ACTIONS #####

function CheckSignUpInfos()	{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))	{
		die ("Wrong email format.");
	}
	if ($_POST['email'] !== $_POST['emailConf'])	{
		die ("Email adresses not matching.");
	}
	if ($_POST['passwd'] !== $_POST['passwdConf'])	{
		die ("Passwords not matching.");
	}
	$error = db_UserExist();
	if ($error)	{
		die ($error);
	}

}