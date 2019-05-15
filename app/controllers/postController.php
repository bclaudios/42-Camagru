<?php
require_once __DIR__.'/../models/PostModel.php';
require_once __DIR__.'/../controllers/userController.php';


##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "createPost")
		CreatePost();
}

##### VIEWS #####
function view_WebcamPost()	{
	$title = "New Post";
	$stickers = ["frame1.png", "frame2.png", "frame3.png", "frame4.png", "frame5.png", "frame6.png", "frame7.png", "frame8.png", "frame9.png", "frame10.png"];
	require_once("app/views/pages/webcamPost.php");
}

function view_FilePost()	{
	$title = "New Post";
}

###### ACTIONS #####
function CreatePost()	{
	$img = $_POST['img'];
	$sticker = $_POST['sticker'];
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
	}
	file_put_contents("img.png", $img);
	$img = imagecreatefrompng("img.png");
	$sticker = imagecreatefrompng("../assets/img/stickers/".$sticker);
	imagecopy($img, $sticker, 0, 0, 0, 0, 800, 600);
	imagepng($img, "img@.png");
	echo "img"
	// 	$user = GetCurrentUser();
	// 	if (!file_exists("../assets/img/posts/".$user['login']))	{
	// 		mkdir("../assets/img/posts/".$user['login']);
	// 	}
	// 	$path = "../assets/img/posts/".$user['login']."/".time().".png";
	// 	file_put_contents($path, $img);
	// 	PostModel::db_CreatePost($path, $user['user_id']);
	// 	echo "Post created.";
	// } else {
	// 	http_response_code(400);
	// 	echo "MIME corrupted.";
	// }
}