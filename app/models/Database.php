<?php

abstract class Database	{

	static function Connect()	{
		try {
			$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "rqiden", [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]);
			return $db;
		} catch (Exception $ex) {
			die ("Database connection error: " . $ex->getMessage());
		}
	}
}