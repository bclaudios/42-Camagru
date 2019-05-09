<?php

function db_Connect()	{
	try {
		$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqiden", [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
		return $db;
	} catch (Exception $ex) {
		die ("Error in db_Connect(): " . $ex->getMessage());
	}
}

function db_CreatePost($path, $user_id)	{
	$db = db_Connect();
	try {
		$req = $db->prepare("INSERT INTO posts
							(user_id, date, time, path)
							VALUES
							(:user_id, NOW(), NOW(), :path)");
		$req->execute([
			"user_id" => $user_id,
			"path" => $path
		]);
	} catch(PDOException $ex) {
		die("Error in db_CreatePost(): " . $ex->getMessage());
	}
}