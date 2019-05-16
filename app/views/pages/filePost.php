<?php require_once("app/views/layouts/header.php"); ?>
<body>
	<h2>Create a new post</h2>
	<main>

		<!-- FILE UPLOAD -->
		<div>
			<h3>Please select a file to upload (png)</h3>
			<form action="index.php?page=filePost" method="post" enctype="multipart/form-data">
				<input type="file" name="img" accept="<?=$ext?>">
				<button type="submit">Upload picture</button>
			</form>
		</div>
		<?php 
		if (!empty($tmpPath))	{?>
			<!-- DISPLAY PICTURE AND ENABLE STICKER SELECTION -->
			<div>
				<h2>Select your sticker</h2>
				<div id="overlay">
					<div id="sticker" style="position:absolute;"></div>
					<img id="photo" alt="La photo de ma webcam" src="<?=$tmpPath?>">
				</div>
			</div>
			<button type="submit">Create post</button>
			<div>
				<?php foreach ($stickers as $stick)	{
					echo "<img src='app/assets/img/stickers/" . $stick . "' class='stickers' id='".$stick."' style='height:100px;width:100px;'>";
				} ?>
			</div>
		<?php } ?>
	</main>
	<script type="text/javascript" src="/app/assets/js/stickers.js"></script>
</body>