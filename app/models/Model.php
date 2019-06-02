<?php

class Model	{

	public static function db_Connect()	{
		try {
			$db = new PDO("mysql:host=localhost;dbname=camagru", "root", "", [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]);
			return $db;
		} catch (Exception $ex) {
			die ("Database connection error: " . $ex->getMessage());
		}
	}
}