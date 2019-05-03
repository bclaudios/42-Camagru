<?php

function db_Connect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqiden", [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
		return $db;
	} catch (Exception $ex) {
		die ("Error : " . $ex->getMessage());
	}
}

function db_UserExist($login, $email)	{
	$db = db_Connect();
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
		if ($user['login'] === $login)	{
			return "Login is already used.";
		}
		if ($user['email'] === $email)	{
			return "Email address is already used.";
		}
	} catch (PDOException $e) {
		die ("Error in db_UserExist(): " . $e->getMessage());
	}
}

function db_CreateUser($user)	{
	$db = db_Connect();
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

function db_GetUser($user)	{
	$db = db_Connect();
	try {
		$req = $db->prepare("SELECT * FROM users WHERE 
							`login` LIKE :login
							OR
							`email` LIKE :email");
		$req->execute([
			"login" => $user,
			"email" => $user
		]);
		$user = $req->fetch();
		if (empty($user))	{
			return (NULL);
		}
		return ($user);
	} catch (PDOException $e)	{
		die ("Error in db_GetUSer(): " . $e->getMessage());
	}
}

function db_UpdateProfil($newLogin, $newPasswd)	{
	$db = db_Connect();
	try {
		$req = $db->prepare("UPDATE users SET 
							`login` = :newLogin,
							`email` = :newEmail
							WHERE `login` LIKE :login");
		$req->execute([
			"newLogin" => $newLogin,
			"newEmail" => $newEmail,
			"login" => $_SESSION['user']
		]);
	} catch (PDOException $e)	{
		die ("Error in db_UpdateUser(): " . $e->getMessage());
	}
}

function db_UpdatePasswd($newPasswd)	{
	$db = db_Connect();
	try	{
		$req = $db->prepare("UPDATE users SET `passwd` = :newPasswd WHERE `login` = :login");
		$req->execute([
			"newPasswd" => $newPasswd,
			"login" => $_SESSION['user']
		]);
	} catch (PDOExcpetion $e)	{
		die ("Error in db_UpdateUserPasswd(): " . $e->getMessage());
	}
}