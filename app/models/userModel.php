<?php

require_once("Model.php");

class UserModel {

	public static function db_UserExist($login, $email)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users WHERE 
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
	
	public static function db_CreateUser($user)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("INSERT INTO users 
							(login, email, passwd) 
							VALUES 
							(:login, :email, :passwd)");
		$req->execute([
			"login" => $user["login"],
			"email" => $user["email"],
			"passwd" => $user["passwd"]
			]);
		} catch (PDOException $e)	{
			die ("Error in db_CreateUser(): " . $e->getMessage());
		}
	}
	
	public static function db_GetUser($login)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users WHERE `login` LIKE :login");
			$req->execute(["login" => $login]);
			$user = $req->fetch();
			if (empty($user))	{
				return (NULL);
			}
			return ($user);
		} catch (PDOException $e)	{
			die ("Error in db_GetUSer(): " . $e->getMessage());
		}
	}
	
	public static function db_CheckEmail($email)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM users WHERE `email` LIKE :email");
			$req->execute(["email" => $email]);
			$user = $req->fetch();
			if (empty($user))
			return (NULL);
			return ($user);
		} catch (PDOException $e)	{
			die ("Error in db_CheckEmail(): " . $e->getMessage());
		}
	}
	
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
}