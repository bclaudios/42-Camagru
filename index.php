<?php
require_once("app/controllers/userController.php");

if (isset($_GET['page']))	{
	$page = $_GET['page'];
	if ($page === "signUp")
		view_SignUp();
	if ($page === "signIn")
		view_SignIn();
	if($page === "profil")
		view_Profil();
	if ($page === "editProfil")
		view_EditProfil();
	if ($page === "newPost")
		view_newPost();
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action === "logOut")
		LogOut();
}
view_Home();