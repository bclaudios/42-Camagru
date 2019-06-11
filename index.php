<?php
require_once("app/controllers/userController.php");
require_once("app/controllers/postController.php");

###### PAGES ROUTEUR ######

if (isset($_GET['page']))	{
	$page = $_GET['page'];

	if ($page === "signUp") { view_SignUp(); }
	elseif ($page === "signIn") { view_SignIn(); }
	elseif ($page === "resetPasswd") { view_ResetPasswd(); }
	elseif ($page === "profil") { view_Profil(); }
	elseif ($page === "post") { view_Post(); }
	elseif (isset($_SESSION['user'])) {
		if ($page === "editProfil") { view_EditProfil(); }
		if ($page === "webcamPost") { view_WebcamPost(); }
		if ($page === "filePost") { view_FilePost(); }
	}
	
	##### ACTIONS ROUTEUR #####
	
} elseif (isset($_GET['action']) && CheckToken()) {
	$action = $_GET['action'];
	
	//	USER ACTION
	//	[Connected]
	if ($action === "confirm") { ConfirmEmail(); }
	elseif ($action === "resetPasswd") { ResetPasswd(); }
	if (isset($_SESSION['user'])) {
		if ($action === "logOut") 			{ LogOut(); }
		if ($action === "updatePic")		{ UpdateProfilPic(); }
	}
} else { view_Gallery(); }