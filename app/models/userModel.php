<?php

require_once("Model.php");

class UserModel {

	// Valid User Function
	public static function db_CreateUser($user)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("INSERT INTO users 
							(login, email, passwd, profilPic) 
							VALUES 
							(:login, :email, :passwd, :profilPic)");
			$req->execute([
				"login" => $user["login"],
				"email" => $user["email"],
				"passwd" => $user["passwd"],
				"profilPic" => "placeholderPic.jpg"
			]);
		} catch (PDOException $ex)	{
			die ("Error in db_CreateUser(): " . $ex->getMessage());
		}
	}

	public static function db_DeleteUser($login)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("DELETE FROM users
								WHERE login = :login");
			$req->execute([
				"login" => $login
			]);
		} catch (PDOException $ex) {
			die ("Error in db_DeleteUser(): " . $ex->getMessage());
		}
	}

	public static function db_UserExist($login, $email)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users 
							WHERE 
							`login` LIKE :login 
							OR 
							`email` LIKE :email;");
			$req->execute([
				'login' => $login,
				'email' => $email
			]);
			$user = $req->fetch();
			if (empty($user))
				return NULL;
			if ($user['login'] === $login)
				return "Login is already used.";
			if ($user['email'] === $email)
				return "Email address is already used.";
		} catch (PDOException $e) {
			die ("Error in db_UserExist(): " . $e->getMessage());
		}
	}
	
	public static function db_GetUser($login)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users 
								WHERE 
								`login` LIKE :login");
			$req->execute([
				"login" => $login
			]);
			$user = $req->fetch();
			if (empty($user))	{
				return (NULL);
			}
			return ($user);
		} catch (PDOException $e)	{
			die ("Error in db_GetUser(): " . $e->getMessage());
		}
	}
	
	
	//	UPDATES FUNCTION
	public static function db_UpdateLogin($newLogin)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("UPDATE users SET 
							`login` = :newLogin
							WHERE `login` LIKE :login");
		$req->execute([
			"newLogin" => $newLogin,
			"login" => $_SESSION['user']
			]);
		} catch (PDOException $e)	{
			die ("Error in db_UpdateLogin(): " . $e->getMessage());
		}
	}
	
	public static function db_UpdateEmail($newEmail)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("UPDATE users SET 
							`email` = :newEmail
							WHERE `login` LIKE :login");
		$req->execute([
			"newEmail" => $newEmail,
			"login" => $_SESSION['user']
			]);
		} catch (PDOException $e)	{
			die ("Error in db_UpdateEmail(): " . $e->getMessage());
		}
	}
	
	public static function db_CheckEmailExist($email)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users 
								WHERE 
								`email` LIKE :email");
			$req->execute([
				"email" => $email
			]);
			$user = $req->fetch();
			if (empty($user))
				return (FALSE);
			return (TRUE);
		} catch (PDOException $e)	{
			die ("Error in db_CheckEmailExist(): " . $e->getMessage());
		}
	}
	
	public static function db_UpdatePasswd($newPasswd)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("UPDATE users SET 
							`passwd` = :newPasswd 
							WHERE `login` = :login");
		$req->execute([
			"newPasswd" => $newPasswd,
			"login" => $_SESSION['user']
			]);
		} catch (PDOExcpetion $e)	{
			die ("Error in db_UpdatePasswd(): " . $e->getMessage());
		}
	}

	public static function db_UpdateProfilPic() {
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("UPDATE users SET 
							`profilPic` = :picPath 
							WHERE `login` = :login");
		$req->execute([
			"path" => $_SESSION['user']."jpg",
			"login" => $_SESSION['user']
			]);
		} catch (PDOExcpetion $e)	{
			die ("Error in db_UpdateProfilPic(): " . $e->getMessage());
		}
	}
}