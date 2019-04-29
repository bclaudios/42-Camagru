<?php

function db_Connect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "root", [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
		return $db;
	} catch (Exception $ex) {
		die ("Error : " . $ex->getMessage());
	}
}

function db_UserExist()	{
	$db = db_Connect();
	try {
		$req = $db->prepare("SELECT * FROM users WHERE 
							`login` LIKE :login 
							OR 
							`email` LIKE :email;");
		$req->execute([
			'login' => $_POST['login'],
			'email' => $_POST['email']
			]);
		$user = $req->fetch();
		if (empty($user))	{
			return false;
		}
		if ($user['login'] === $_POST['login'])	{
			return "Login is already used.";
		}
		if ($user['email'] === $_POST['email'])	{
			return "Email adress is already used.";
		}
	} catch (PDOException $e) {
		die ("Error in db_UserExist(): " . $e->getMessage());
	}
}

function db_AddUser()	{
	$db = db_Connect();
	try	{
		$req = $db->prepare("INSERT INTO users 
							(login, email, passwd) 
							VALUES 
							(:login, :email, :passwd)");
		$req->execute([
			"login" => $_POST["login"],
			"email" => $_POST["email"],
			"passwd" => $_POST["passwd"]
		]);
	} catch (PDOException $e)	{
		die ("Error in db_AddUser(): " . $e->getMessage());
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
			return (false);
		}
		return ($user);
	} catch (PDOException $e)	{
		die ("Error in db_GetUSer(): " . $e->getMessage());
	}
}

function db_UpdateUser()	{
	$db = db_Connect();
	try {
		$req = $db->prepare("UPDATE users SET 
							`login` = :newLogin,
							`email` = :newEmail
							WHERE `login` LIKE :login");
		$req->execute([
			"newLogin" => $_POST['newLogin'],
			"newEmail" => $_POST['newEmail'],
			"login" => $_SESSION['logguedUser']['login']
		]);
	} catch (PDOException $e)	{
		die ("Error in db_UpdateUser(): " . $e->getMessage());
	}
}