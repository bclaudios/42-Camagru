<?php
require_once __DIR__.'/../models/PostModel.php';
require_once __DIR__.'/../controllers/userController.php';
// session_start();

##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "createPost")
		CreatePost();
	if ($action === "uploadPost")
		print_r($_FILE);
}

function view_Montage()	{
	$title = "New Post";
	require_once("app/views/pages/montage.php");
}

function CreatePost()	{
	$img = $_POST['img'];
	if (preg_match('/^data:image\/(\w+);base64,/', $img, $type))	{
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$type = $type[1];
		if ($type !== "png")	{
			http_response_code(400);
			echo "File extension not valid.";
			die;
		}
		$img = base64_decode($img);
		if ($img === FALSE)	{
			http_response_code(400);
			echo "Decoding failed.";
			die;
		}

		$user = GetCurrentUser();
		if (!file_exists("../assets/img/posts/".$user['login']))	{
			mkdir("../assets/img/posts/".$user['login']);
		}
		$path = "../assets/img/posts/".$user['login']."/".time().".png";
		file_put_contents($path, $img);
		PostModel::db_CreatePost($path, $user['user_id']);
		echo "Post created.";
	} else {
		http_response_code(400);
		echo "MIME corrupted.";
	}
}

function PostUpload()	{
	echo $_FILES['photo']['name'];
}