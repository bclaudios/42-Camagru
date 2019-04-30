<?php
require_once("app/controllers/userController.php");
session_start();

if (isset($_GET['page']))	{
	$page = $_GET['page'];
	if ($page === "signup")	
		view_SignUp();
	if ($page === "signin")	
		view_SignIn();
	if($page === "profil")	
		view_Profil();
	if ($page === "changeinfo")	
		view_EditUserInfos();
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action === "adduser")
		RegisterUser();
	if ($action === "loguser")	
		LogUser();
	if ($action === "logout")
		LogOutUser();
	if ($action === "editprofil")
		UpdateUserProfil();
}
view_Home();