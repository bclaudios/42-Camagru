<?php

function db_Connect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqiden", [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);
	} catch (Exception $ex) {
		die ("Error : " . $ex->getMessage());
	}
}

function db_UserExist()	{
	$db = db_Connect();
	try {
		$req = $db->prepare("SELECT * FROM users
						WHERE `login` = :login OR
						`email` = :email OR");
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