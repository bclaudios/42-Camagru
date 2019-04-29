<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=$title?></title>
</head>
<header style="border-bottom: 3px solid black;">
	<a href="index.php">
		<h1>Camagru</h1>
	</a>
	<?php if (empty($_SESSION['logguedUser']))	{?>
		<a href="index.php?page=signup">Sign Up</a>
		<a href="index.php?page=signin">Sign In</a>
	<?php } else {?>
		<a href="index.php?page=profil">Profil</a>
		<a href="index.php?action=logout">Disconnect</a>
	<?php } ?>
</header>