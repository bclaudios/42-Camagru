<?php

require_once __DIR__."/Model.php";

class PostModel	{

	public static function db_CreatePost($path, $user_id)	{
		$db = Model::db_Connect();
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
}