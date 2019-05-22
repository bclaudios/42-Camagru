<?php
require_once __DIR__.'/../models/PostModel.php';
require_once __DIR__.'/../controllers/userController.php';


##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "createPost")
		CreatePost();
	
} else {
	view_Home();
}

if (isset($_GET['action']))	{
	if ($_GET['action'] === "test")	{
		UserModel::db_DeleteUser("bclaudio");
		$results = PostModel::db_GetNLastPosts(5);
		foreach($results as $result)	{
			echo "<br>";
			print_r($result);
			echo "<br>";
		}
	}
}

##### VIEWS #####
function view_WebcamPost()	{
	$title = "New Post";
	$stickers = ["frame1.png", "frame2.png", "frame3.png", "frame4.png", "frame5.png", "frame6.png", "frame7.png", "frame8.png", "frame9.png", "frame10.png"];
	$user = GetCurrentUser();
	$lastPosts = PostModel::db_GetLastPosts($user['user_id'], 5);
	require_once("app/views/pages/postWebcam.php");
}

function view_FilePost()	{
	$title = "New Post";
	$stickers = ["frame1.png", "frame2.png", "frame3.png", "frame4.png", "frame5.png", "frame6.png", "frame7.png", "frame8.png", "frame9.png", "frame10.png"];
	$tmpPath = "";
	$ext = ".png";
	if (isset($_FILES['uploaded_img']))	{
		if ($_FILES['uploaded_img']['size'] > 1048576)
			die ("Selecte file is too big");
		$uploaded_img = $_FILES['uploaded_img']['tmp_name'];
		$tmpPath = DownloadUserImage($uploaded_img);
	}
	require_once("app/views/pages/postFile.php");
}

/*********** ACTIONS ***********/

###### POST CREATION ######
function CreatePost()	{
	if ($_POST['source'] === "webcam")
		$img = DecodeMIME($_POST['img']);
	else {
		$img = imagecreatefrompng($_POST['img']);
		unlink(__DIR__."/../assets/img/posts/".$_SESSION['user']."/tmp.png");
	}
	$sticker = imagecreatefrompng($_POST['sticker']);
	imagecopy($img, $sticker, 0, 0, 0, 0, 800, 600);
	$montage = CreateMontageFile($img);
	echo $montage;
}

function CreateMontageFile($img)	{
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
	PostModel::db_CreatePost($fileName, $user['user_id']);
	return $fileName;
}

###### WEBCAM POST ######
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
		if ($img === FALSE)	{
			http_response_code(400);
			echo "Decoding failed.";
			die;
		}
		$img = imagecreatefromstring($img);
		imageflip($img, IMG_FLIP_HORIZONTAL);
		return $img;
	} else {
		http_response_code(400);
		echo "MIME data corrupted.";
	}
}

###### FILE POST ######
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