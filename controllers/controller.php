<?php
require("models/model.php");

function Home()	{
	$user = GetUsers();
	print_r($user);
	require("views/homeView.php");
}

function SignUp()	{
	require("views/signupView.php");
}

function CreateUser($infos)	{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))	{
		echo "Wrong email format<br>";
		die;
	}
	if ($_POST['email'] !== $_POST['emailconf'])	{
		echo "Email adresse not matching.<br>";
		die;
	}
	if (!preg_match("~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$~", $_POST['passwd']))	{
		echo "Password not strong enough.";
		die;
	}
	if ($_POST['passwd'] !== $_POST['passwdconf'])	{
		echo  "Password not matching.<br>";
		die;
	}
	$passwd = hash("sha256", $_POST['passwd']);
	$user = array("login" => $_POST['login'], "email" => $_POST['email'], "passwd" => $passwd);
	Adduser($user);
	Home();
}

// DEV //
function DelUsersTable(){
	FlushUsersTable();
	header("Location: index.php");
}