<?php
session_start();
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/postController.php';

########## CONTROLLER ##########

if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "signIn") 				{ SignIn(); }
	elseif ($action === "signUp")			{ SignUp(); }
	elseif ($action === "sendResetPasswd") 	{ SendResetMail(); }
	elseif ($action === "resetPasswd")		{ ResetPasswd(); }
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
	if (isset($_GET['login'])) {
		$title = "Profil";
		$login = $_GET['login'];
		$user = UserModel::db_GetUser($login);
		if ($user) {
			$posts = PostModel::db_GetPostsFromUser($user['user_id']);
			$likeCount = 0;
			$commentCount = 0;
			foreach ($posts as &$post) {
				$likeCount += $post["likesCount"];
				$commentCount += sizeof(PostModel::db_GetAllCommentsFromPost($post['post_id']));
			}
			require_once(__DIR__."/../views/pages/profil.php");
		} else {
			view_Gallery();
		}
	}
}

function view_EditProfil()	{
	$title = "Edit Infos";
	$user = GetCurrentUser();
	require_once(__DIR__."/../views/pages/profil-edit.php");
}

function view_Message($messageTitle, $message) {
	$title = "Camagru";
	require_once(__DIR__."/../views/pages/message.php");
}

function view_ForgotPasswd()	{
	$title = "Reset Password";
	require_once(__DIR__."/../views/pages/passwd-forgot.php");
}

function view_ResetPasswd()	{
	if (isset($_GET['h'])) {
		$title = "Reset Password";
		$hash = $_GET['h'];
		$user = UserModel::db_GetUserByResetHash($hash);
		if (empty($user))
		view_Gallery();
		else {
			$_SESSION['resetUser'] = $user;
			require_once(__DIR__."/../views/pages/passwd-reset.php");
		}
	}
}

function view_ChangePasswd() {
	$title = "Reset Password";
	require_once(__DIR__."/../views/pages/changePassword.php");
}

########## SIGN UP ##########

function CheckSignUpInfos()	{
	if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwd']) && isset($_POST['passwdConf'])) {
		if (empty($_POST['login']) || empty($_POST['email']) || empty($_POST['passwd']) || empty($_POST['passwdConf']))
		$errorLogs[] = "Please, fill all the fields below.";
		else {
			if (CheckNewLogin($_POST['login']))
			$errorLogs[] = CheckNewLogin($_POST['login']);
			if (CheckNewEmail($_POST['email']))
			$errorLogs[] = CheckNewEmail($_POST['email']);
			if (!CheckPasswdSecurity($_POST['passwd']))
			$errorLogs[] = "Password security is too low.";
			if ($_POST['passwd'] !== $_POST['passwdConf'])
			$errorLogs[] = "Passwords not matching.";
		}
		if (!isset($errorLogs))
		return NULL;
		return $errorLogs;
	}
}

function SignUp()	{
	if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwd'])) {
		$_POST['login'] = htmlspecialchars($_POST['login']);
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
			$mailLink = "http://localhost:8080/index.php?action=confirm&h=".hash("sha256", $user['email']);
			mail($_POST['email'], "Please, activate your account.", "Welcome to Camagru ! Please clic on the link bellow to confirm your e-mail address. ".$mailLink);
			UserModel::db_CreateUser($user);
		}
	}
}

function ConfirmEmail() {
	if (isset($_GET['h'])) {
		$hash = $_GET['h'];
		if (UserModel::db_CheckHash($hash)) {
			UserModel::db_ConfirmEmail($hash);
			view_Message("E-mail adress confirmed !", "Your email adress has been confirmed. You can now login and share you pictures with your friends !");
		} else
		view_Message("No user found", "Seems like we found no user corresponding to your link. Sorry !");
	}
}

###### SIGN IN | LOGOUT ######

function SignIn()	{
	if (isset($_POST['login']) && isset($_POST['passwd'])) {
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
}

function LogOut()	{
	if (isset($_SESSION['user']))
		unset($_SESSION['user']);
	header("Location: index.php");
}


###### INFOS UPDATE ######

function UpdateInfos() {
	if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['notif'])) {		
		$user = GetCurrentUser();
		$newLogin = $_POST['login'];
		$newEmail = $_POST['email'];
		$notif = $_POST['notif'] === "true" ? "1" : "0";
		if (!empty($newLogin) && $newLogin !== $user['login'])
		$errorLogs[] = CheckNewLogin($newLogin);
		if (!empty($newEmail) && $newEmail !== $user['email'])
		$errorLogs[] = CheckNewEmail($newEmail);
		if (!isset($errorLogs[0])) {
			if (!empty($newLogin) && $newLogin !== $user['login']) {
				UserModel::db_UpdateLogin($newLogin);
				$_SESSION['user'] = $newLogin;
			}
			if (!empty($newEmail) && $newEmail !== $user['email'])	{
				UserModel::db_UpdateEmail($newEmail);
				mail($_POST['email'], "Please, activate your account.", "Your email has been changed. Please clic on the link bellow to confirm your e-mail address. ".$mailLink);
			}
			UserModel::db_UpdateNotif($notif);
		} else {
			http_response_code(403);
			$errorLogs = json_encode($errorLogs);
			echo $errorLogs;
		}
	}
}

function CheckNewLogin($newLogin)	{
	if (!preg_match("~[A-Za-z0-9áéíóú]+$~", $newLogin))
		return "No special character autorized in username.";
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
	if (isset($_POST['passwd']) && isset($_POST['newPasswd']) && isset($_POST['newPasswdConf'])) {
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
		UserModel::db_UpdatePasswd($user['login'], $newPasswd);
		else {
			http_response_code(403);
			$errorLogs = json_encode($errorLogs);
			echo $errorLogs;
		}
	}
}

function SendResetMail() {
	if (isset($_POST['login'])) {
		$user = UserModel::db_GetUser($_POST['login']);
		if (empty($user)) {
			http_response_code(400);
			$errorLogs[] = "This user doesn't exist.";
			$errorLogs = json_encode($errorLogs);
			echo $errorLogs;
		} else {
			$hash = hash("sha256", RandomString());
			$link = "http://localhost:8080/index.php?page=resetPasswd&h=".$hash;
			$subject = "Reset your password.";
			$mail = "Click on the link to reset your password. ".$link;
			mail($user['email'], $subject, $mail);
			UserModel::db_AddResetHash($user['login'], $hash);
			echo "An e-mail has been sent to ".$user['email'].".";
		}
	}
}

function ResetPasswd() {
	if (isset($_POST['passwd']) && isset($_POST['passwdConf']) && isset($_SESSION['resetUser'])) {
		$newPasswd = hash("sha256", $_POST['passwd']);
		$newPasswdConf = hash("sha256", $_POST['passwdConf']);
		$user = $_SESSION['resetUser'];
		if ($newPasswd !== $newPasswdConf)
		$errorLogs[] = "Passwords not matching.";
		elseif (!CheckPasswdSecurity($_POST['passwd']))
		$errorLogs[] = "New password security too low.";
		if (!isset($errorLogs[0])) {
			UserModel::db_UpdatePasswd($user['login'], $newPasswd);
			echo "Your password has been successfuly changed. You can now login.";
		}
		else {
			http_response_code(403);
			$errorLogs = json_encode($errorLogs);
			echo $errorLogs;
		}
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