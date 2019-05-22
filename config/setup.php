<?php

//	Block script execution if requested from server
if ($_SERVER['REQUEST_METHOD']) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

require_once("database.php");

//	Log Variables
$database = "\033[33m[".ucfirst($DB_NAME)." Database]\033[37m";
$sqlServer = "\033[34m[SQL Server]\033[37m";
$TABLE_NAME = null;
$table = "\033[32m[".$TABLE_NAME." Table]\033[37m";

try	{
	$db = new PDO("mysql:host=".$DB_HOST, $DB_USER, $DB_PASSWORD, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	print($sqlServer." Connection granted.\n");
	//	DELETE DATABASE
	$db->exec("DROP DATABASE IF EXISTS ".$DB_NAME);
	print($database." Dropped.\n");
	//	RECREATE A FRESH DATABASE
	$db->exec("CREATE DATABASE ".$DB_NAME);
	print($database." Created.\n");
	//	CONNNECT TO THE FRESH DATABASE
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	print($database." Connection granted.\n");
	//	CREATE USER TABLE
	$db->exec("CREATE TABLE users 
				(`user_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
				`login` VARCHAR(40) NOT NULL UNIQUE,
				`email` VARCHAR(255) NOT NULL UNIQUE,
				`passwd` VARCHAR(255) NOT NULL,
				`valid` BOOLEAN DEFAULT FALSE)");
	print("Users Table Created.\n");
	//	CREATE POSTS TABLE
	$db->exec("CREATE TABLE posts 
				(`post_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
				`user_id` INT NOT NULL,
				`date` DATE NOT NULL,
				`time` TIME NOT NULL,
				`path` VARCHAR(255) NOT NULL UNIQUE,
				FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE)");
	print("Posts Table Created.\n");
	//	CREATE LIKES TABLE
	$db->exec("CREATE TABLE likes
				(`like_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
				`user_id` INT NOT NULL,
				`post_id` INT NOT NULL,
				FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE, 
				FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE)");
	print("Likes Table Created.\n");
	//	CREATE COMMENT TABLE
	$db->exec("CREATE TABLE comments 
				(`comment_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
				`user_id` INT NOT NULL,
				`post_id` INT NOT NULL,
				`date` DATE NOT NULL,
				`time` TIME NOT NULL,
				`comment` VARCHAR(255) NOT NULL,
				FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
				FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE)");
	print("Comments Table Created.\n");
} catch (PDOException $ex)	{
	die("Database init error: ".$ex->getMessage());
}