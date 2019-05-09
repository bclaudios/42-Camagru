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
	$TABLE_NAME = "users";
	$db->exec("CREATE TABLE ".$TABLE_NAME." 
				(`user_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
				`login` VARCHAR(40) NOT NULL UNIQUE,
				`email` VARCHAR(255) NOT NULL UNIQUE,
				`passwd` VARCHAR(255) NOT NULL,
				`valid` BOOLEAN DEFAULT FALSE)");
	print($TABLE_NAME. " Created.\n");
	//	CREATE POSTS TABLE
	$TABLE_NAME = "posts";
	$db->exec("CREATE TABLE ".$TABLE_NAME." 
				(`post_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
				`user_id` INT NOT NULL,
				`date` DATE NOT NULL,
				`time` TIME NOT NULL,
				`path` CHAR NOT NULL UNIQUE,
				`likes` INT)");
	print($TABLE_NAME. " Created.\n");
} catch (PDOException $ex)	{
	die("Database init error: ".$ex->getMessage());
}