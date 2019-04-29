<?php
require_once("controllers/userController.php");
session_start();
$LogUser = $_SESSION['logguedUser'];

if (isset($_GET['page']))	{
	// PAGES
	$page = $_GET['page'];
	if ($page === "signup")	{
		view_SignUp();
	}
	if ($page === "signin")	{
		view_SignIn();
	}
	if($page === "profil")	{
		view_Profil();
	}
	if ($page === "changeinfo")	{
		view_EditUserInfos();
	}
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action === "adduser")	{
		RegisterUser();
	}
	if ($action === "loguser")	 {
		LogUser();
	}
	if ($action === "logout")	{
		LogOutUser();
	}
	if ($action === "editprofil")	{
		UpdateUserProfil();
	}
}
view_Home();