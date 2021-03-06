<?php
require_once __DIR__.'/../models/PostModel.php';
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/../controllers/userController.php';


##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "getComments") 		{ GetAllCommentsFromPost(); }
	elseif ($action === "updateGallery") { UpdateGallery(); }
	elseif (isset($_SESSION['user']) && CheckToken()) {
		if ($action === "createPost")	{ CreatePost(); }
		if ($action === "addComment")	{ AddComment(); }
		if ($action === "addLike")		{ AddLike(); }
		if ($action === "removeLike")	{ RemoveLike(); }
		if ($action === "delComment")	{ DeleteComment(); }
		if ($action === "deletePost")	{ DeletePost(); }
	}
}

##### VIEWS #####

function view_Gallery()	{
	$title = "Gallery";
	$user = GetCurrentUser();
	$lastsPosts = PostModel::db_GetNLastPosts(5);
	foreach ($lastsPosts as &$post) {
			$post['comments'] = PostModel::db_GetAllCommentsFromPost($post['post_id']);
			$post['user'] = UserModel::db_GetUser($post['login']);
			if ($user)
				$post['liked'] = PostModel::db_UserLiked($user['user_id'], $post['post_id']);
		}
	require_once(__DIR__."/../views/pages/gallery.php");
}

function view_WebcamPost()	{
	$title = "New Post";
	$stickers = ["guirlande.png",
				"cat.png",
				"chestb.png",
				"dirty.png",
				"guirlande.png",
				"guirlande2.png",
				"nemo.png",
				"party.png",
				"spongebob.png",
				"ufo.png",
				"frame1.png",
				"frame2.png",
				"frame3.png",
				"frame4.png",
				"frame5.png",
				"frame6.png",
				"frame7.png",
				"frame8.png",
				"frame9.png",
				"frame10.png",
	];
	$user = GetCurrentUser();
	$ext = "image/png";
	$lastPosts = PostModel::db_GetNLastPostsFromUser($user['user_id'], 4);
	require_once("app/views/pages/postWebcam.php");
}

function view_FilePost()	{
	$user = GetCurrentUser();
	$title = "New Post";
	$stickers = ["guirlande.png",
				"cat.png",
				"chestb.png",
				"dirty.png",
				"guirlande.png",
				"guirlande2.png",
				"nemo.png",
				"party.png",
				"spongebob.png",
				"ufo.png",
				"frame1.png",
				"frame2.png",
				"frame3.png",
				"frame4.png",
				"frame5.png",
				"frame6.png",
				"frame7.png",
				"frame8.png",
				"frame9.png",
				"frame10.png",
	];
	$tmpPath = "";
	$ext = "image/.png";
	if (isset($_FILES['uploaded_img']))	{
		if ($_FILES['uploaded_img']['size'] > 1048576 || $_FILES['uploaded_img']['size'] <= 0)	{
			$sizeError = true;
			$user = GetCurrentUser();
			$lastPosts = PostModel::db_GetNLastPostsFromUser($user['user_id'], 4);
			require_once("app/views/pages/postWebcam.php");
		} elseif (mime_content_type($_FILES['uploaded_img']['tmp_name']) !== "image/png") {
			$fileError = true;
			$user = GetCurrentUser();
			$lastPosts = PostModel::db_GetNLastPostsFromUser($user['user_id'], 4);
			require_once("app/views/pages/postWebcam.php");
		} else {
			$uploaded_img = $_FILES['uploaded_img']['tmp_name'];
			$tmpPath = DownloadUserImage($uploaded_img);
			$lastPosts = PostModel::db_GetNLastPostsFromUser($user['user_id'], 4);
			require_once("app/views/pages/postFile.php");
		}
	} else {
		view_WebcamPost();
	}
}

function view_Post() {
	if (isset($_GET['post_id'])) {
		$title = "Post";
		$user = GetCurrentUser();
		$post_id = $_GET['post_id'];
		$post = PostModel::db_GetPost($post_id);
		if ($post)	{
			$post['comments'] = PostModel::db_GetAllCommentsFromPost($post['post_id']);
			$post['liked'] = PostModel::db_UserLiked($user['user_id'], $post['post_id']);
			$post['user'] = UserModel::db_GetUser($post['login']);
			require_once("app/views/pages/post.php");
		} else {
			view_Gallery();
		}
	}
}

###### POST CREATION ######

function CreatePost()	{
	if (isset($_POST['img']) && isset($_POST['sticker']) && isset($_POST['source'])) {
		$user = GetCurrentUser();
		if ($_POST['source'] === "webcam")
		$img = DecodeMIME($_POST['img']);
		else
		$img = imagecreatefrompng($_POST['img']);
		$sticker = imagecreatefrompng($_POST['sticker']);
		imagecopy($img, $sticker, 0, 0, 0, 0, 800, 600);
		CreateMontageFile($img);
		$post = PostModel::db_GetNLastPostsFromUser($user['user_id'], 1);
		$post = json_encode($post);
		echo $post;
	}
}

function DeletePost() {
	if (isset($_POST['postID'])) {
		$post = PostModel::db_GetPost($_POST['postID']);
		if ($_SESSION['user'] === $post['login']) {
			PostModel::db_DeletePost($post['post_id']);
			unlink("../assets/img/posts/".$post['path']);
		} else {
			http_response_code(400);
			echo "You're not the author of this post.";
		}
	}
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
	$imgSrc = @imagecreatefrompng($relPath); // Create php image (?) from png file
	if (!$imgSrc) {
		$_SESSION['error'] = "Your file seems to be corrupted. Please select another picture.";
		view_WebcamPost();
	} else {
		$srcSize = getimagesize($relPath); // Get the size of the png file for resizing
		$imgDst = imagecreatetruecolor(800, 600); // Generate resize destination image
		imagesavealpha($imgDst, true); // Enable transparency on destination image
		$color = imagecolorallocatealpha($imgDst, 0, 0, 0, 127); // Create alpha color id
		imagefill($imgDst, 0, 0, $color); // Fill destination image with transparency 
		imagecopyresampled($imgDst, $imgSrc, 0, 0, 0, 0, 800, 600, $srcSize[0], $srcSize[1]); // Resize and paste source image on destination image
		imagepng($imgDst, $relPath); // Create png file with the result
		return $tmpPath;
	}
}

###### COMMENTS ######

function AddComment() {
	if (isset($_POST['post_id']) && isset($_POST['comment'])) {
		$user = GetCurrentUser();
		date_default_timezone_set("Europe/Paris");
		$comment = [
			"post_id" => $_POST['post_id'],
			"login" => $user['login'],
			"comment" => htmlspecialchars($_POST['comment']),
			"date" => date("Y-m-d"),
			"time" => date("H:i:s")
		];
		$post = PostModel::db_GetPost($comment['post_id']);
		$comment['comment_id'] = PostModel::db_AddComment($user['user_id'], $comment['post_id'],$comment['comment']);
		$postUser = UserModel::db_GetUser($post["login"]);
		if ($postUser['notif'])
			mail($user['email'], $comment['login'] . " commented your post !", "Click here to see it. \nhttp://localhost:8080/index.php?page=post&post_id=".$comment['post_id']);
		$comment = json_encode($comment);
		echo $comment;
	}
}

function GetAllCommentsFromPost() {
	if (isset($_POST['post_id'])) {
		$post_id = $_POST['post_id'];
		$comments = PostModel::db_GetAllCommentsFromPost($post_id);
		$comments = json_encode($comments);
		echo $comments;
	}
}

function DeleteComment() {
	if (isset($_POST['commentID'])) {
		$commentID = $_POST['commentID'];
		$user = GetCurrentUser();
		if (PostModel::db_CheckCommentAuthor($commentID, $user['user_id'])) {
			PostModel::db_DeleteComment($commentID);
			echo "Comment deleted.";
		} else {
			http_response_code(403);
			echo "You're not the author of this comment.";
		}
	}
}

###### LIKES #######

function AddLike() {
	if (isset($_POST['post_id'])) {
		$user = GetCurrentUser();
		$post_id = $_POST['post_id'];
		PostModel::db_AddLike($user['user_id'], $post_id);
		echo "Like ajoute";
	}
}

function RemoveLike() {
	if (isset($_POST['post_id'])) {
		$user = GetCurrentUser();
		$post_id = $_POST['post_id'];
		PostModel::db_DeleteLike($user['user_id'], $post_id);
		echo "Like removed";
	}
}

###### PAGIONATION ######

function requireToVar($file, $post){
    ob_start();
    require($file);
    return ob_get_clean();
}

function UpdateGallery() {
	if (isset($_POST['offset'])) {
		$user = GetCurrentUser();
		$lastsPosts = PostModel::db_GetNLastPostsOff(5, $_POST['offset']);
		foreach ($lastsPosts as &$post) {
			$post['comments'] = PostModel::db_GetAllCommentsFromPost($post['post_id']);
			$post['user'] = UserModel::db_GetUser($post['login']);
			if ($user)
			$post['liked'] = PostModel::db_UserLiked($user['user_id'], $post['post_id']);
			$post = requireToVar("../views/layouts/_card.php", $post);
		}
		$lastsPosts = json_encode($lastsPosts);
	}
		echo $lastsPosts;
}