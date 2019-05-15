<?php
require_once("app/controllers/userController.php");
require_once("app/controllers/postController.php");

##### PAGES ROUTEUR #####
if (isset($_GET['page']))	{
	$page = $_GET['page'];
	//	USER VIEWS
	if ($page === "signUp")
		view_SignUp();
	if ($page === "signIn")
		view_SignIn();
	if($page === "profil")
		view_Profil();
	if ($page === "editProfil")
		view_EditProfil();
	//	POST VIEWS
	if ($page === "webcamPost")
		view_WebcamPost();
	if ($page === "filePost")
		view_FilePost();

##### ACTIONS ROUTEUR #####
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action === "logOut")
		LogOut();
}
view_Home();