<?php

require_once __DIR__."/Model.php";

class PostModel	{

	//	POST
	//	Add update post if description added to posts
	public static function db_CreatePost($path, $user_id)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("INSERT INTO posts
							(user_id, date, time, path)
							VALUES
							(:user_id, NOW(), NOW(), :path)");
			$test = $req->execute([
				"user_id" => $user_id,
				"path" => $path
			]);
			return $test;
		} catch(PDOException $ex) {
			die("Error in db_CreatePost(): " . $ex->getMessage());
		}
	}

	public static function db_DeletePost($post_id)	{
		$db = Model::db_Connect();
		try {
			$req = $db->prepare("DELETE FROM posts
								WHERE post_id = :post_id");
			$req->execute([
				"post_id" => $post_id,
			]);
		} catch(PDOException $ex) {
			die("Error in db_DeletePost(): " . $ex->getMessage());
		}
	}
		
	public static function db_GetPost($post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
			(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT	1) AS lastComment 
			FROM posts
			LEFT JOIN users ON posts.user_id = users.user_id
			LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
				FROM likes
				GROUP BY post_id)
			likesCount ON likesCount.post_id = posts.post_id
			WHERE posts.post_id = :post_id");
			$req->execute([
				"post_id" => $post_id
			]);
			$post = $req->fetch();
			return $post;
		} catch (PDOExcpetion $ex) {
			die("Error in db_GetPost(): " . $ex->getMessage());
		}
	}
	
	public static function db_GetAllPosts()	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
				(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT	1) AS lastComment 
				FROM posts 
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
					FROM likes
					GROUP BY post_id)
				likesCount ON likesCount.post_id = posts.post_id
				ORDER BY post_id DESC");
			$req->execute();
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetAllPosts(): " . $ex->getMessage());
		}
	}

	public static function db_GetNLastPosts($count)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
				(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT 1) AS lastComment 
				FROM posts 
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
					FROM likes
					GROUP BY post_id)
				likesCount ON likesCount.post_id = posts.post_id
				ORDER BY post_id DESC
				LIMIT ".$count);
			$req->execute();
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetNLastPosts(): " . $ex->getMessage());
		}
	}
	
	public static function db_GetNLastPostsFromUser($user_id, $count)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
				(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT	1) AS lastComment 
				FROM posts 
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
					FROM likes
					GROUP BY post_id)
				likesCount ON likesCount.post_id = posts.post_id
				WHERE posts.user_id = :user_id
				ORDER BY post_id DESC
				LIMIT ".$count);
			$req->execute([
				"user_id" => $user_id,
			]);
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetNLastPostsFromUser(): " . $ex->getMessage());
		}
	}

	public static function db_GetPostsFromUser($user_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
				(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT	1) AS lastComment 
				FROM posts 
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
					FROM likes
					GROUP BY post_id)
				likesCount ON likesCount.post_id = posts.post_id
				WHERE posts.user_id = :user_id
				ORDER BY post_id DESC");
			$req->execute([
				"user_id" => $user_id,
			]);
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetNLastPostsFromUser(): " . $ex->getMessage());
		}
	}

	public static function db_GetNLastPostsOff($count, $offset)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT posts.post_id, users.login, posts.date, posts.time, posts.path, likesCount, 
				(SELECT comment FROM comments WHERE comments.post_id = posts.post_id ORDER BY comment_id DESC LIMIT 1) AS lastComment 
				FROM posts 
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN (SELECT post_id, COUNT(*) AS likesCount
					FROM likes
					GROUP BY post_id)
				likesCount ON likesCount.post_id = posts.post_id
				ORDER BY post_id DESC
				LIMIT ".$count . " OFFSET " . $offset);
			$req->execute();
			$posts = $req->fetchAll();
			return $posts;
		} catch (PDOException $ex) {
			die ("Error in db_GetNLastPosts(): " . $ex->getMessage());
		}
	}
	//	LIKES
	//	Get which user liked a post ???
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

	public static function db_DeleteLike($user_id, $post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("DELETE FROM likes
								WHERE 
								user_id = :user_id
								AND
								post_id = :post_id");
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $post_id
			]);
		}	catch (PDOException $ex) {
			die("Error in db_DeleteLike(): " . $ex->getMessage());
		}
	}

	public static function db_UserLiked($user_id, $post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT *
								FROM likes
								WHERE
								user_id = :user_id
								AND
								post_id = :post_id");
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $post_id
			]);
			$like = $req->fetch();
			if (empty($like))
				return FALSE;
			return TRUE;
		} catch (PDOException $ex) {
			die("Error in db_UserLiked(): " . $ex->getMessage());
		}
	}

	//	COMMENTS
	public static function db_AddComment($user_id, $post_id, $comment)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("INSERT INTO comments
								(`user_id`, `post_id`, `date`, `time`, `comment`)
								VALUES
								(:user_id, :post_id, NOW(), NOW(), :comment)");
			$req->execute([
				"user_id" => $user_id,
				"post_id" => $post_id,
				"comment" => $comment
			]);
			return $db->lastInsertId(); 
		} catch (PDOException $ex) {
			die("Error in db_AddComment(): " . $ex->getMessage());
		}
	}

	public static function db_DeleteComment($comment_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("DELETE FROM comments
								WHERE comment_id = :comment_id");
			$req->execute([
				"comment_id" => $comment_id
			]);
		} catch (PDOException $ex) {
			die("Error in db_DeleteComment(): " . $ex->getMessage());
		}
	}

	public static function db_GetAllCommentsFromPost($post_id)	{
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT comments.comment_id, users.login, comments.post_id, comments.date, comments.time, comments.comment
								FROM comments
								LEFT JOIN users ON comments.user_id = users.user_id
								WHERE post_id = :post_id
								ORDER BY comment_id ASC");
			$req->execute(["post_id" => $post_id]);
			$comments = $req->fetchAll();
			return $comments;
		} catch (PDOException $ex) {
			die("Error in db_GetAllCommentsFromPost(): " . $ex->getMessage());
		}
	}

	public static function db_CheckCommentAuthor($comment_id, $user_id) {
		$db = Model::db_Connect();
		try	{
			$req = $db->prepare("SELECT * FROM comments
								WHERE
								comment_id = :comment_id
								AND
								user_id = :user_id");
			$req->execute([
				"comment_id" => $comment_id,
				"user_id" => $user_id
				]);
			$comment = $req->fetch();
			if (!empty($comment))
				return TRUE;
			return FALSE;
		} catch (PDOException $ex) {
			die("Error in db_GetAllCommentsFromPost(): " . $ex->getMessage());
		}
	}
}