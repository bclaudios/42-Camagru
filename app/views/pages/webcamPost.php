<?php require_once("app/views/layouts/header.php"); ?>
<body>
	<h2>Create a new post</h2>
	<main>
		<div>
			<h2>Your Webcam</h2>
			<p>No webcam ? Upload a picture <a href="index.php?page=filePost">here</a></p>
		</div>
		<div id="overlay">
			<div id="sticker" style="position:absolute;">
			</div>
			<video id="video" autoplay></video>
		</div>
		<button id="startButton">Take a snapshot</button><br>
		<div>
		<?php
		foreach ($stickers as $stick)	{
			echo "<img src='app/assets/img/stickers/" . $stick . "' class='stickers' id='".$stick."' style='height:100px;width:100px;'>";
		} ?>
		</div>
	</main>
	<h2>Your picture</h2>
	<canvas id="canvas" hidden></canvas>
	<img id="photo" alt="La photo de ma webcam">
	<div>
		
	</div>
	<script type="text/javascript" src="/app/assets/js/webcam.js"></script>
	<script type="text/javascript" src="/app/assets/js/stickers.js"></script>
</body>