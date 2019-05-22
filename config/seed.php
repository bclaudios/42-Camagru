<?php
//	Block script execution if requested from server
if ($_SERVER['REQUEST_METHOD']) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

require_once("database.php");

function RandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

try	{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	//	USER SEEDING
	$users = ["bclaudio", "bboucher", "julaurai", "axelgerv", "alstupin", "pimichau", "salibert"];
	$password = hash("sha256", "Qwerty123");
	$req = $db->prepare("INSERT INTO users 
						(login, email, passwd) 
						VALUES 
						(:login, :email, :passwd)");
	foreach ($users as $user)	{
		$req->execute([
			"login" => $user,
			"email" => $user."@monzbi.com",
			"passwd" => $password
		]);
	}
	print(sizeof($users)." users successfully created.\n");

	//	POSTS SEEDING
	$path = "path/de/test/";
	$user_id = 1;
	$req = $db->prepare("INSERT INTO posts
						(user_id, date, time, path)
						VALUES
						(:user_id, NOW(), NOW(), :path)");
	foreach ($users as $user) {
		for ($i = 1; $i < 6; $i++)	{
			$req->execute([
				"user_id" => $user_id,
				"path" => $path . $user . "/" . $i
			]);
		}
		$user_id++;
	}
	$postCount = sizeof($users) * 5;
	print($postCount . " posts successfully created\n");

	//	LIKE SEEDING
	$req = $db->prepare("INSERT INTO likes 
								(user_id, post_id)
								VALUES
								(:user_id, :post_id)");
	$user_id = 1;
	foreach ($users as $user) {
		for ($i = 1; $i <= $postCount; $i++)	{
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $i
			]);
		}
		$user_id++;
	}
	$likesCount = $postCount * sizeof($users);
	print($likesCount . " likes successfully created.\n");

	//	COMMENT SEEDING
	$user_id = 1;
	$req = $db->prepare("INSERT INTO comments
						(`user_id`, `post_id`, `date`, `time`, `comment`)
						VALUES
						(:user_id, :post_id, NOW(), NOW(), :comment)");
	foreach ($users as $user)	{
		for ($i = 1; $i <= $postCount; $i++)	{
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $i,
				"comment" => RandomString()
			]);
		}
		$user_id++;
	}
	print($likesCount . " commentary successfully created.\n");
} catch(PDOException $ex) {
	die("Error while creating seed: " . $ex->getMessage());
}