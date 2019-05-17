<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- <link rel="stylesheet" href="postWebcam.css"> -->
	<title><?=$title?></title>
</head>
<header style="border-bottom: 3px solid black;">
	<a href="index.php">
		<h1>Camagru</h1>
	</a>
	<?php if (empty($_SESSION['user']))	{?>
		<a href="/index.php?page=signUp">Sign Up</a>
		<a href="/index.php?page=signIn">Sign In</a>
	<?php } else { ?>
		<a href="/index.php?page=webcamPost">New Post</a>
		<a href="/index.php?page=profil">Profil</a>
		<a href="/index.php?action=logOut">Disconnect</a>
	<?php } ?>
</header>