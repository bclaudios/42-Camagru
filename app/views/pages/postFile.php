<?php require_once(__DIR__."/../layouts/header.php"); ?>
<body>
	<h2>Create a new post</h2>
	<main>

		<!-- FILE UPLOAD -->
		<div>
			<h3>Please select a file to upload (.PNG / 1 Mo max.)</h3>
			<form action="index.php?page=filePost" method="post" enctype="multipart/form-data">
				<input type="file" name="uploaded_img" accept="<?=$ext?>">
				<button type="submit">Upload picture</button>
			</form>
		</div>
		<?php 
		if (!empty($tmpPath))	{?>
			<!-- DISPLAY PICTURE AND ENABLE STICKER SELECTION -->
			<div>
				<h2>Select a sticker</h2>
				<div id="overlay">
					<div id="sticker" style="position:absolute;"></div>
					<img id="uploaded_img" alt="Uploaded image" src="<?=$tmpPath?>">
				</div>
				<button type="submit" id="post_btn">Create post</button>
			</div>
			<div>
				<?php foreach ($stickers as $stick)	{
					echo "<img src='app/assets/img/stickers/" . $stick . "' class='stickers' id='".$stick."' style='height:100px;width:100px;'>";
				} ?>
			</div>
		<?php } ?>
	</main>
	<script type="text/javascript" src="/app/assets/js/postFile.js"></script>
	<script type="text/javascript" src="/app/assets/js/stickers.js"></script>
</body>