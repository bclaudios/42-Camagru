<?php

function dbConnect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqden");
		return $db;
	}
	catch (Exception $ex)	{
		die ("Error : " . $ex->getMessage());
	}
}

function GetUsers()	{
	$db = dbConnect();
	$users = $db->query("SELECT * FROM users");
	return $users;
}