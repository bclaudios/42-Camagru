<?php
//	Block script execution if requested from server
if ($_SERVER['REQUEST_METHOD']) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

require_once("database.php");

try	{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	$users = ["bclaudio", "bboucher", "julaurai", "axelgerv", "alstupin", "pimichau", "salibert"];
	$password = hash("sha256", "Qwerty123");
	foreach ($users as $user)	{
		$req = $db->prepare("INSERT INTO users 
							(login, email, passwd) 
							VALUES 
							(:login, :email, :passwd)");
		$req->execute([
			"login" => $user,
			"email" => $user."@monzbi.com",
			"passwd" => $password
		]);
	}
	print(sizeof($users)." users successfully created.\n");
} catch(PDOException $ex) {
	die("Error while creating seed: " . $ex->getMessage());
}