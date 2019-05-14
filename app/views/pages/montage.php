<?php require_once("app/views/layouts/header.php"); ?>
<body>
	<h2>Montage</h2>
	<main>
	<form action="index.php?page=montage" method="post" enctype="multipart/form-data">
		<input type="file" name="photo" id="uploadedFile" required>
		<input type="submit" id="uploadFile">
	</form>
		<video id="video" autoplay></video>
		<button id="startButton">Take a snapshot</button>
		<canvas id="canvas" hidden></canvas>
		<img id="photo" alt="La photo de ma webcam">
	</main>
	<div>
		
	</div>
	<script type="text/javascript" src="/app/assets/js/montage.js"></script>
</body>