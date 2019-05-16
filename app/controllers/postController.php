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
	$stickers = ["frame1.png", "frame2.png", "frame3.png", "frame4.png", "frame5.png", "frame6.png", "frame7.png", "frame8.png", "frame9.png", "frame10.png"];
	$tmpPath = "";
	$ext = ".png";
	if (isset($_FILES['img']))	{
		$img = $_FILES['img']['tmp_name'];
		$tmpPath = DownloadUserImage($img);
	}
	require_once("app/views/pages/filePost.php");
}

function DownloadUserImage($img)	{
	$user = $_SESSION['user'];
	if (!file_exists(__DIR__."/../assets/img/posts/".$user))
		mkdir(__DIR__."/../assets/img/posts/".$user);
	$tmpPath = "/app/assets/img/posts/".$user."/tmp.png";	// Path for js script
	$relPath = __DIR__."/../assets/img/posts/".$user."/tmp.png"; // Path for php script
	move_uploaded_file($img, $relPath); // Create png file of the uploaded image
	$imgSrc = imagecreatefrompng($relPath); // Create php image (?) from png file
	$srcSize = getimagesize($relPath); // Get the size of the png file for resizing
	$imgDst = imagecreatetruecolor(800, 600); // Generate resize destination image
	imagesavealpha($imgDst, true); // Enable transparency on destination image
	$color = imagecolorallocatealpha($imgDst, 0, 0, 0, 127); // Create alpha color id
	imagefill($imgDst, 0, 0, $color); // Fill destination image with transparency 
	imagecopyresampled($imgDst, $imgSrc, 0, 0, 0, 0, 800, 600, $srcSize[0], $srcSize[1]); // Resize and paste source image on destination image
	imagepng($imgDst, $relPath); // Create png file with the result
	return $tmpPath;
}
###### ACTIONS #####
function CreatePost()	{
	$imgSrc = DecodeMIME($_POST['img']);
	$img = imagecreatefromstring($imgSrc);
	$stickerName = $_POST['sticker'];
	$sticker = imagecreatefrompng("../assets/img/stickers/".$stickerName);
	imagecopy($img, $sticker, 0, 0, 0, 0, 800, 600);
	echo CreateImgFile($img);
}

function CreateImgFile($img)	{
	$user = GetCurrentUser();
	if (!file_exists("../assets/img/posts/".$user['login']))
		mkdir("../assets/img/posts/".$user['login']);
	$fileName = $user['login']."/".time().".png";
	$path = "../assets/img/posts/".$fileName;
	if (imagepng($img, $path) === FALSE) {
		http_response_code(400);
		echo "Image creation failed.";
		die;
	};
	PostModel::db_CreatePost($path, $user['user_id']);
	return $fileName;
}

function DecodeMIME($data)	{
	if (preg_match('/^data:image\/(\w+);base64,/', $data, $type))	{
		$data = str_replace('data:image/png;base64,', '', $data);
		$data = str_replace(' ', '+', $data);
		if ($type[1] !== "png")	{
			http_response_code(400);
			echo "File extension not valid.";
			die;
		}
		$img = base64_decode($data);
		if ($data === FALSE)	{
			http_response_code(400);
			echo "Decoding failed.";
			die;
		}
		return $img;
	} else {
		http_response_code(400);
		echo "MIME data corrupted.";
		die;
	}
}