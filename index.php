<?php
require_once("app/controllers/userController.php");
require_once("app/controllers/postController.php");

if (isset($_GET['page']))	{
	$page = $_GET['page'];

	//	USER ROUTEUR
	if ($page === "signUp")
		view_SignUp();
	if ($page === "signIn")
		view_SignIn();
	if($page === "profil")
		view_Profil();
	if ($page === "editProfil")
		view_EditProfil();

	//	POST ROUTEUR
	if ($page === "montage")	{
		if (isset($_FILES['photo']))	{
			print_r($_FILES);
			die;
		}
		view_Montage();
	}
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action === "logOut")
		LogOut();
}
view_Home();