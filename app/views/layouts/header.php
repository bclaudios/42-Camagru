<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css">
	<link rel="stylesheet" href="app/assets/css/main.css">
	<link rel="stylesheet" href="app/assets/css/card.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
</head>
<body>
	<header>
		<div class="container">
			<nav class="navbar">
				<div class="navbar-brand">
					<a class="navbar-item" href="index.php">
						<h1>Camagru</h1>
					</a>
					<a class="navbar-burger burger">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>
				<!-- IF USER IS LOG -->
				<div class="navbar-menu">
					<div class="navbar-end">
						<?php if (!empty($_SESSION['user'])) { ?>
							<a href="/index.php?page=webcamPost" class="navbar-item">New Post</a>
							<a href="/index.php?page=profil" class="navbar-item">Profil</a>
							<div class="navbar-item">
									<a href="/index.php?action=logOut" class="button is-primary">Disconnect</a>
							</div>
					<!-- IF USER IS NOT LOG -->
						<?php } else { ?>
							<div class="navbar-item">
									<a href="index.php?page=signUp">Sign Up</a>
							</div>
							<div class="navbar-item">
									<a href="index.php?page=signIn" class="button is-primary">Sign In</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</nav>
		</div>
	</header>