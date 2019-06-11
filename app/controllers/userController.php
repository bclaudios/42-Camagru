<?php
session_start();
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/postController.php';

########## CONTROLLER ##########

if (isset($_POST['action']) && CheckToken())	{
	$action = $_POST['action'];
	if ($action === "signIn") 				{ SignIn(); }
	elseif ($action === "signUp")			{ SignUp(); }
	elseif ($action === "sendResetPasswd") 	{ SendResetMail(); }
	elseif ($action === "resetPasswd")		{ ResetPassword(); }
	elseif (isset($_SESSION['user'])) {
		if ($action === "updateInfos")		{ UpdateInfos(); }
		if ($action === "updatePasswd")		{ UpdatePasswd(); }
		if ($action === "deleteAccount")	{ DeleteAccount(); }
	}
}

########## VIEWS ##########

function view_SignUp()	{
	$title = "Sign Up";
	require_once(__DIR__."/../views/pages/signUp.php");
}

function view_SignIn()	{
	$title = "Sign In";
	require_once(__DIR__."/../views/pages/signIn.php");
}

function view_Profil()	{
	$title = "Profil";
	$login = $_GET['login'];
	$user = UserModel::db_GetUser($login);
	$posts = PostModel::db_GetPostsFromUser($user['user_id']);
	require_once(__DIR__."/../views/pages/profil.php");
}

function view_EditProfil()	{
	$title = "Edit Infos";
	$user = GetCurrentUser();
	require_once(__DIR__."/../views/pages/profilEdit.php");
}

function view_Message($messageTitle, $message) {
	$title = "Camagru";
	require_once(__DIR__."/../views/pages/message.php");
}

function view_ResetPasswd()	{
	$title = "Reset Password";
	require_once(__DIR__."/../views/pages/resetPassword.php");
}

function view_ChangePasswd() {
	$title = "Reset Password";
	require_once(__DIR__."/../views/pages/changePassword.php");
}

########## SIGN UP ##########

function CheckSignUpInfos()	{
	if (CheckNewLogin($_POST['login']))
		$errorLogs[] = CheckNewLogin($_POST['login']);
	if (CheckNewEmail($_POST['email']))
		$errorLogs[] = CheckNewEmail($_POST['email']);
	if (!CheckPasswdSecurity($_POST['passwd']))
		$errorLogs[] = "Password security is too low. Must contain at least 8 chars, 1 lowercase, 1 uppercase and 1 digit.";
	if ($_POST['passwd'] !== $_POST['passwdConf'])
		$errorLogs[] = "Passwords not matching.";
	if (!isset($errorLogs))
		return NULL;
	return $errorLogs;
}

function SignUp()	{
	$errorLogs = CheckSignUpInfos();
	if (!empty($errorLogs))	{
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	} else {
		$user = array(
			"login" => $_POST['login'],
			"email" => $_POST['email'],
			"passwd" => hash('sha256', $_POST['passwd']),
			"hash" => hash("sha256", $_POST['email'])
		);
		$mailLink = "http://localhost/index.php?action=confirm&h=".hash("sha256", $user['email']);
		mail($_POST['email'], "Please, activate your account.", "Welcome to Camagru ! Please clic on the link bellow to confirm your e-mail address. ".$mailLink);
		UserModel::db_CreateUser($user);
		echo "Registration complete.\nPlease confirm your address by clicking on the link sent at the one you specified.";
	}
}

function ConfirmEmail() {
	$hash = $_GET['h'];
	if (UserModel::db_CheckHash($hash)) {
		UserModel::db_ConfirmEmail($hash);
		view_Message("E-mail adress confirmed !", "Your email adress has been confirmed. You can now login and share you pictures with your friend !");
	} else
		view_Message("No user found", "Seems like we found no user corresponding to your link. Sorry !");
}

###### SIGN IN | LOGOUT ######

function SignIn()	{
	$passwd = hash("sha256", $_POST['passwd']);
	$user = UserModel::db_GetUser($_POST['login']);
	if ($user === FALSE || $user['passwd'] !== $passwd)	{
		http_response_code(400);
		$errorLogs[] = "Login or password incorrect.";
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	} elseif ($user['valid'] == FALSE) {
		http_response_code(400);
		$errorLogs[] = "You must have validate your email before login in.";
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	} else {
		$_SESSION['user'] = $user['login'];
		echo "You are now logged in.";
	}
}

function LogOut()	{
	unset($_SESSION['user']);
	header("Location: index.php");
}


###### INFOS UPDATE ######

function UpdateInfos() {
	$user = GetCurrentUser();
	$newLogin = $_POST['login'];
	$newEmail = $_POST['email'];
	$notif = $_POST['notif'];
	if (!empty($newLogin) && $newLogin !== $user['login'])
		$errorLogs[] = CheckNewLogin($newLogin);
	if (!empty($newEmail) && $newEmail !== $user['email'])
		$errorLogs[] = CheckNewEmail($newEmail);
	if (!isset($errorLogs[0])) {
		if (!empty($newLogin) && $newLogin !== $user['login']) {
			UserModel::db_UpdateLogin($newLogin);
			$_SESSION['user'] = $newLogin;
		}
		if (!empty($newEmail) && $newEmail !== $user['email'])
			UserModel::db_UpdateEmail($newEmail);
		UserModel::db_UpdateNotif($notif);
	} else {
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	}
}

function CheckNewLogin($newLogin)	{
	if (UserModel::db_GetUser($newLogin))
		return "This username is already used.";
	return NULL;
}

function CheckNewEmail($newEmail)	{
	if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
		$errors[] = "Wrong email format.";
	elseif (UserModel::db_CheckEmailExist($newEmail))
		$errors[] = "This email address is already used.";
	if (!isset($errors))
		return NULL;
	return $errors;
}

###### PASSWORD UPDATE ######

function UpdatePasswd()	{
	$user = GetCurrentUser();
	$passwd = hash("sha256", $_POST['passwd']);
	$newPasswd = hash("sha256", $_POST['newPasswd']);
	$newPasswdConf = hash("sha256", $_POST['newPasswdConf']);
	if ($passwd !== $user['passwd'])
		$errorLogs[] = "Wrong current password.";
	elseif ($newPasswd !== $newPasswdConf)
		$errorLogs[] = "Passwords not matching.";
	elseif (!CheckPasswdSecurity($_POST['newPasswd']))
		$errorLogs[] = "New password security too low.";
	if (!isset($errorLogs[0]))
		UserModel::db_UpdatePasswd($newPasswd);
	else {
		http_response_code(403);
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	}
}

function SendResetMail() {
	$user = UserModel::db_GetUser($_POST['login']);
	if (empty($user)) {
		http_response_code(400);
		$errorLogs[] = "This user doesn't exist.";
		$errorLogs = json_encode($errorLogs);
		echo $errorLogs;
	} else {
		$hash = hash("sha256", RandomString());
		$link = "http://localhost/index.php?action=resetPasswd&h=".$hash;
		$subject = "Reset your password.";
		$mail = "Click on the link to reset your password. ".$link;
		mail($user['email'], $subject, $mail);
		UserModel::db_AddResetHash($user['login'], $hash);
		echo "An e-mail has been sent to ".$user['email'].".";
	}
}

function ResetPasswd() {
	$hash = $_GET['h'];
	$user = UserModel::db_GetUserByResetHash($hash);
	if (empty($user))
		view_Gallery();
	else {
		$_SESSION['resetUser'] = $user;
		view_ChangePasswd();
	}
}

##### PROFIL PIC ######

function UpdateProfilPic() {
	if (isset($_FILES['uploaded_img']) && isset($_SESSION['user'])) {
			if ($_FILES['uploaded_img']['size'] > 1048576)
				die ("Selecte file is too big");
			else {
				$user = GetCurrentUser();
				if (!file_exists(__DIR__."/../assets/img/profil"))
					mkdir(__DIR__."/../assets/img/profil");
				$uploaded_img = $_FILES['uploaded_img']['tmp_name'];
				$path = __DIR__."/../assets/img/profil/".$user['login'].".jpg";
				move_uploaded_file($_FILES['uploaded_img']['tmp_name'], $path);
				UserModel::db_UpdateProfilPic($user['login'], $user['login'].".jpg");
		}
	}
	view_EditProfil();
}

##### ACCOUNT SUPPRESSION ######

function DeleteAccount() {
	$user = GetCurrentUser();
	UserModel::db_DeleteUser($user['login']);
	unset($_SESSION['user']);
}

###### TOOLS ######

function CheckPasswdSecurity($passwd)	{
	if (!preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$^", $passwd))
		return FALSE;
	return TRUE;
}

function GetCurrentUser()	{
	if (isset($_SESSION['user']))
		return UserModel::db_GetUser($_SESSION['user']);
	return NULL;
}

###### TOOLS ######

function CheckToken() {
	if (isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] === $_POST['token'])
		return true;
	return false;
}

function RandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}