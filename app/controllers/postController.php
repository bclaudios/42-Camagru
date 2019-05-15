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
	$imgSrc = $_POST['img'];
	$stickerName = $_POST['sticker'];
	if (preg_match('/^data:image\/(\w+);base64,/', $imgSrc, $type))	{
		$imgSrc = str_replace('data:image/png;base64,', '', $imgSrc);
		$imgSrc = str_replace(' ', '+', $imgSrc);
		$type = $type[1];
		if ($type !== "png")	{
			http_response_code(400);
			echo "File extension not valid.";
			die;
		}
		$imgSrc = base64_decode($imgSrc);
		if ($imgSrc === FALSE)	{
			http_response_code(400);
			echo "Decoding failed.";
			die;
		}
	}
	$img = imagecreatefromstring($imgSrc);
	$sticker = imagecreatefrompng("../assets/img/stickers/".$stickerName);
	imagecopy($img, $sticker, 0, 0, 0, 0, 800, 600);
	$user = GetCurrentUser();
	if (!file_exists("../assets/img/posts/".$user['login']))	{
		mkdir("../assets/img/posts/".$user['login']);
	}
	$fileName = $user['login']."/".time().".png";
	$path = "../assets/img/posts/".$fileName;
	imagepng($img, $path);
	echo $fileName;
}