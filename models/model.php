<?php

function dbConnect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqiden");
		return $db;
	}
	catch (Exception $ex)	{
		die ("Error : " . $ex->getMessage());
	}
}

function GetUsers()	{
	$db = dbConnect();
	$users = $db->query("SELECT * FROM users");
	$users = $users->fetchAll(PDO::FETCH_ASSOC);
	return $users;
}

function AddUser($user)	{
	$db = dbConnect();
	$req = $db->prepare("INSERT INTO users (`login`,`email`,`passwd`) VALUE (:login, :email, :passwd);");
	if (!$req->execute($user))	{
		echo "SQL request failed.";
		die;
	}
	unset($db);
	header("Location: index.php");
}

// DEV FUCNTION //

function FlushUsersTable()	{
	$db = dbConnect();
	$db->query("DROP TABLE users");
	$db->query("CREATE TABLE users (`user_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, `email` VARCHAR(255) NOT NULL, `login` VARCHAR(40) NOT NULL, `passwd` varchar(255) NOT NULL);");
}