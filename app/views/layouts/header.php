<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
</head>
<header>
<div class="container">
	<div class="columns">
		<div class="column is-four-fifths">
			<a href="index.php">
				<h1>Camagru</h1>
			</a>
		</div>
		<div class="column">
			<?php if (empty($_SESSION['user']))	{?>
				<a href="/index.php?page=signUp" class="button">Sign Up</a>
				<a href="/index.php?page=signIn" class="button is-primary">Sign In</a>
			<?php } else { ?>
				<a href="/index.php?page=webcamPost" class="button">New Post</a>
				<a href="/index.php?page=profil" class="button">Profil</a>
				<a href="/index.php?action=logOut" class="button">Disconnect</a>
			<?php } ?>
		</div>
	</div>
	</div>
</header>