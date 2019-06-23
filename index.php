<?php
require_once("app/controllers/userController.php");
require_once("app/controllers/postController.php");

###### PAGES ROUTEUR ######

if (isset($_GET['page']))	{
	$page = $_GET['page'];

	if ($page === "signUp") { view_SignUp(); }
	elseif ($page === "validSignUp") { 
		$msgTitle = "Welcome to Camagru !";
		$msg = "We have sent you a confirmation e-mail at the specified address. Please, check your inbox and confirm your email.";
		view_Message($msgTitle, $msg);
	}
	elseif ($page === "signIn") { view_SignIn(); }
	elseif ($page === "forgotPasswd") { view_forgotPasswd(); }
	elseif ($page === "profil") { view_Profil(); }
	elseif ($page === "post") { view_Post(); }
	elseif ($page === "resetPasswd") { view_ResetPasswd(); }
	elseif (isset($_SESSION['user'])) {
		if ($page === "editProfil") { view_EditProfil(); }
		if ($page === "webcamPost") { view_WebcamPost(); }
		if ($page === "filePost") { view_FilePost(); }
	}
	
	##### ACTIONS ROUTEUR #####
	
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
	
	//	USER ACTION
	//	[Connected]
	if ($action === "confirm") { ConfirmEmail(); }
	elseif ($action === "logOut") 			{ LogOut(); }
	if (isset($_SESSION['user'])) {
		if ($action === "updatePic")		{ UpdateProfilPic(); }
	}
} else { view_Gallery(); }