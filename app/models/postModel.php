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

	public static function db_AddLike($user_id, $post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("INSERT INTO likes 
								(user_id, post_id)
								VALUES
								(:user_id, :post_id)");
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $post_id
			]);
		}	catch (PDOException $ex) {
			die("Error in db_AddLike(): " . $ex->getMessage());
		}
	}

	public static function db_GetLastPosts($user_id, $count)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("SELECT * FROM posts WHERE
								`user_id` LIKE :user_id
								ORDER BY post_id DESC
								LIMIT 5");
			$req->execute([
				"user_id" => $user_id
				]);
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die("Error in db_GetLastPosts: " . $ex->getMessage());
		}
	}

	public static function db_GetPost($post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, (SELECT COUNT(*) FROM likes WHERE post_id = :post_id) AS likesCount, (SELECT comment FROM comments WHERE comments.post_id = :post_id LIMIT 1) as comment
								FROM posts
								LEFT JOIN users ON users.user_id = posts.user_id
								LEFT JOIN likes ON likes.post_id = posts.post_id
								WHERE posts.post_id = :post_id 
								GROUP BY post_id");
			$req->execute([
				"post_id" => $post_id
			]);
			$post = $req->fetchAll();
			return $post;
		} catch (PDOExcpetion $ex) {
			die("Error in db_GetPost(): " . $ex->getMessage());
		}
	}

	public static function db_GetAllPosts()	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount FROM posts
								LEFT JOIN users ON posts.user_id = users.user_id
								LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
									FROM likes
									GROUP BY post_id)
								likesCount ON likesCount.post_id = posts.post_id");
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetAllPosts(): " . $ex->getMessage());
		}
	}
}